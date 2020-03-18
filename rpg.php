<?php

abstract class Character 
{
    public static $count = 0;
    protected $name;
    protected $id;
    protected $age;
    protected $stats = array("dex" => 5, "str" => 6);
    protected $health;
    protected $stamina;
    protected $energy;
	protected $combat_skills;
	protected $social_skills;
    protected $survival_skills;
    protected $position;

    abstract protected function get_id();

    abstract protected function get_stats();

    abstract protected function get_stat($stat_name);

    abstract protected function get_position();

    abstract protected function set_position($position_column_letter);

    // abstract protected function get_health();

    // abstract protected function get_stamina();

    // abstract protected function get_energy();

    // abstract protected function get_str();

    // abstract protected function get_dex();

    // abstract protected function get_per();

    // abstract protected function battle_map_move_squares();


}

class PC extends Character 
{
    public function __construct($id, $name) 
    {
        $this->id = $id;
        $this->name = $name;
        $this::$count++;
    }

    public function get_id()
    {
        return $this->id;    
    }

    public function get_position() 
    {
        return $this->position;
    }

    public function set_position($position_letter_int)
    {
        $this->position = $position_letter_int;
    }

    public function get_stats()
    {
        return $this->stats;
    }

    public function get_stat($stat_name)
    {
        $statsArr = get_stats();
        return $statsArr[$stat_name];
    }
}

class Ally extends Character 
{
    public function __construct($id, $name) 
    {
        $this->id = $id;
        $this->name = $name;
        $this::$count++;
    }

    public function get_id()
    {
        return $this->id;    
    }

    public function get_position() 
    {
        return $this->position;
    }

    public function set_position($position_letter_int)
    {
        $this->position = $position_letter_int;
    }

    public function get_stats()
    {
        return $this->stats;
    }

    public function get_stat($stat_name)
    {
        $statsArr = $this->get_stats();
        return $statsArr[$stat_name];
    }

    public function greet() 
    {
        $open_phrase = "Hello, friend. How can ".$this->name." be of service to your cause?";
        echo $open_phrase;
    }
}

class BattleMap
{
    private $characters = array();
    private $squares = array(
        "A" => array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14
        ),
        "B" => array(
            0,
            1,
            2,
            3,
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14
        )
    );

    public function __construct($charactersArr) 
    {
        $this->characters = $charactersArr;
        $this->set_character_positions();
    }

    public function get_filled_positions() 
    {
        $characters = $this->get_characters();
        $filled_positions = array();
        foreach ($characters as $character) 
        {
            if ( $character->get_position() != null ) 
            {
                $filled_positions[] = $character->get_position();
            }
        }
        return $filled_positions;
    }

    public function get_squares() 
    {
        return $this->squares;
    }

    public function get_characters() 
    {
        return $this->characters;
    }

    public function get_character($character_id) 
    {
        $charactersArr = $this->get_characters();
        $character = $charactersArr[$character_id];
        return $character; 
    }

    public function set_character_positions()
    {
        // Loop character inside battlemap
        $characters = $this->get_characters();
        foreach ($characters as $character) 
        {
            $next_char = false;
            // If character position is null, set to first un-filled position
            if ($character->get_position() == null) 
            {
                $filled_positions = $this->get_filled_positions();
                foreach ($this->get_squares() as $columnLetter => $valueArr) 
                {
                    for ($i=0; $i < count($valueArr); $i++) 
                    {
                        if ($next_char == true) 
                        {
                            continue;
                        }
                        $position_letter_val = array($columnLetter => $valueArr[$i]);
                        if ( !in_array($position_letter_val, $filled_positions) ) 
                        {
                            $character->set_position($position_letter_val);
                            $filled_positions[] = $position_letter_val;
                            $next_char = true;
                        }
                    }
                }
            }
        }
    }

}


$pc = new PC(0, "Kang");
$mara = new Ally(1, "Mara");
$battle_map = new BattleMap(array($pc, $mara));
// $battle_map->set_character_positions();

$mara->greet();
echo "<br>";

echo "Dexterity Stat: " . $mara->get_stat("dex");
echo "<br>";


echo Character::$count;

?>