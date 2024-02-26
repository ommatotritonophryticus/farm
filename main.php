<?php

class Animal {
    public string $name = "Animal";
    public string $product_name;
    public string $id;
    public function __construct() {
        $this->id = uniqid();
    }

    public function get_product(): int
    {
        return 1;
    }

}

class Chicken extends Animal {

    public string $name = "Chicken";
    public string $product_name = "Egg";

    public function get_product(): int
    {
        return random_int(0, 1);
    }
}

class Cow extends Animal {

    public string $name = "Cow";
    public string $product_name = "Milk";

    public function get_product(): int
    {
        return random_int(8, 12);
    }
}

class Farm {

    private array $animals = array();
    private array $products_in_week = array();

    public function __construct( int $number_of_cows = 10, int $number_of_chicken = 20 ) {

        for($i = 0; $i < $number_of_cows; $i++) {
            $this->add_animal(new Cow());
        }
        for($i = 0; $i < $number_of_chicken; $i++) {
            $this->add_animal(new Chicken());
        }
    }

    public function get_animals_info(): array
    {
        $animals = [];
        foreach ($this->animals as $animal) {
            if(!(in_array($animal->name, array_keys($animals)))) {
                $animals[$animal->name] = 0;
            }
            $animals[$animal->name]++;
        }
        return $animals;
    }

    public function get_products_info(): array
    {
        return $this->products_in_week;
    }

    public function get_string_info_about_animals(): string
    {
        $result = "";
        foreach ($this->get_animals_info() as $animal => $count) {
            $result .= "{$animal}: {$count}; ";
        }
        return $result;
    }

    public function get_string_info_about_products(): string
    {
        $result = '';
        foreach ($this->get_products_info() as $product => $count) {
            $result .= "{$product}: {$count}; ";
        }
        return $result;
    }

    private function get_product_from_animal(Animal $animal): void {
        if( !(in_array( $animal->product_name, $this->products_in_week) ) ) {
            $this->products_in_week[$animal->product_name] = 0;
        }
        $this->products_in_week[$animal->product_name] += $animal->get_product();
    }

    private function work_day(): void
    {
        foreach($this->animals as $animal) {
            $this->get_product_from_animal($animal);
        }
    }

    public function add_animal(Animal $animal): void
    {
        $this->animals[] = $animal;
    }

    public function workflow(): void
    {
        echo $this->get_string_info_about_animals() . "\n";

        for($i = 0 ; $i < 7 ; $i++) {
            $this->work_day();
        }

        echo $this->get_string_info_about_products() . "\n";

        for ( $i = 0 ; $i < 5 ; $i++ ) $this->add_animal(new Chicken());

        $this->add_animal(new Cow());

        echo $this->get_string_info_about_animals() . "\n";

        for($i = 0 ; $i < 7 ; $i++) {
            $this->work_day();
        }

        echo $this->get_string_info_about_products() . "\n";


    }
}

$farm = new Farm();
$farm->workflow();
