<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProveedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'folio_padron' => $this->faker->regexify('[0-9]{3}'),
            'rfc' => $this->faker->regexify('[A-Z]{3}[0-9]{4}[A-Z0-9]{3}'),
            'constancia' => $this->faker->date($format = 'd-m-Y', $max = 'now'),
            'nombre' => $this->faker->name(),
            'persona' => $this->faker->randomElement($array = array ('Fisica','Moral')),
            'nacionalidad' => $this->faker->randomElement($array = array ('Nacional','Internacional')),
            'mipyme' => $this->faker->randomElement($array = array ('Si','No')),
            'tipo_pyme' => $this->faker->randomElement($array = array ('pequeña','micro')),
            'codigo_postal' => $this->faker->regexify('[0-9]{5}'),
            'colonia' => $this->faker->state(),
            'alcaldia' => $this->faker->state(),
            'entidad_federativa' => $this->faker->state(),
            'pais' => $this->faker->country(),
            'tipo_vialidad' => $this->faker->randomElement($array = array ('Avenida','calle','callejon')),
            'vialidad' => $this->faker->streetName(),
            'numero_exterior' => $this->faker->regexify('[0-9]{1,3}'),
            'numero_interior' => $this->faker->regexify('[0-9]{1,3}'),
            'nombre_legal' => $this->faker->name(),
            'primer_apellido_legal' => $this->faker->firstName(),
            'segundo_apellido_legal' => $this->faker->firstName(),
            'telefono_legal' => $this->faker->regexify('[0-9]{10}'),
            'extension_legal' => $this->faker->regexify('[0-9]{3,4}'),
            'celular_legal' => $this->faker->regexify('[0-9]{10}'),
            'correo_legal' => $this->faker->email(),
        ];
    }
}
