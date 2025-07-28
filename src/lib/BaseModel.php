<?php

namespace App\model;

abstract class BaseModel
{
    public function __construct(array $data = [])
    {
        if ($data) {
            $this->fill($data);
        }
    }

    /**
     * Preenche os atributos do model a partir de um array associativo
     */
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            // Só preenche se a propriedade existe
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * Retorna o model como array associativo
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
