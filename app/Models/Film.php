<?php 

class Film
{
    public int $id;
    public string $title;
    public string $genre;
    public int $year;


    public function __construct()
    {
        
    }

    /**
     * @param int|string $identificator : film id or slug
     * @return array film
     */
    public static function get(int|string $identificator)
    {
        
    }


    /**
     * @return array films
     */
    public static function getAll()
    {

    }


    /**
     * deletes film
     * @param int|string $identificator film id or slug
     */
    public function delete(int|string $identificator)
    {
        
    }

    /**
     * updates film
     * @param array $data must be ["column" => "value"]
     */
    public function update(array $data)
    {
        
    }


    /**
     * returns current film id
     */
    private function getID()
    {

    }


    /**
     * returns current film slug
     */
    private function getSlug()
    {

    }
}
