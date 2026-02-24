<?php 

namespace Core;

class Validator
{
    private array $validate_in = [];
    private array $rules = [];
    private array $errors = [];

    public function __construct(array $validate_in)
    {
        $this->validate_in = $validate_in;
    }

    public function rule($field_name, $rule)
    {
        if(!is_array($rule)) {
            $rule = [$rule];
        }
        $this->rules[] = [$field_name, $rule];
    }

    
    public function validate(): bool
    {
        foreach($this->rules as $rule) {
            $field_name = $rule[0];
            $field_rules = $rule[1];
            $field_value = $this->validate_in[$field_name] ?? null;
            // if(isset($field_value)) {
                foreach($field_rules as $field_rule) {
                    if($this->$field_rule($field_value) === false) {
                        $this->error($field_name, $field_rule);
                    }
                }
            // }
        }

        return empty($this->errors);
    }

    private function error($field_name, $field_rule)
    {
        $errorMessage = VALIDATION_MESSAGES;

        $this->errors[$field_name][] = str_replace('%field_name%', $field_name, $errorMessage[$field_rule]);
    }

    private function required($field): bool
    {
        return ($field && $field !== '');
    }

    private function password($field): bool
    {
        return (strlen($field)) > 5;
    }



    public function getErrors($field_name = ''): array
    {
        if($field_name !== '') {
            return $this->errors[$field_name];
        }
        return $this->errors;
    }


}