<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class EvaluacionUnica implements Rule
{
    protected $model;
    protected $tipo;
    protected $campos;

    public function __construct($model, $tipo, $campos)
    {
        $this->model = $model;
        $this->tipo = $tipo;
        $this->campos = $campos;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Verificar si ya existe un registro con los mismos valores
        if(isset($this->campos['anio']) && isset($this->campos['serie']) && isset($this->campos['sector']) && isset($this->campos['mes']) && isset($this->campos['edad'])){
            return !$this->model::where('anio', $this->campos['anio'])
                            ->where('idserie', $this->campos['serie'])
                            ->where('idsector', $this->campos['sector'])
                            ->where('mes', $this->campos['mes'])
                            ->where('idedad', $this->campos['edad'])
                            ->where('tipo', $this->tipo)
                            ->exists();
        }
        else
            return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ya existe una evaluación para el mismo año, serie, ambiente, subambiente, sector, mes y edad';
    }
}
