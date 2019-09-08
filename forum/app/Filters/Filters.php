<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{
    protected $request, $builder;
    protected $filters=[];
    public function __construct(Request $request){
        $this->request=$request;    
    }
    
    /**
     * Undocumented function
     *
     * @param [type] $builder
     * @return void
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as  $filter=>$value) {
            if (method_exists($this,$filter)){
                $this->$filter($value);
            }
        }

        
        return $this->builder;
    }

    /**
     * Obtiene las filtros del request.
     *
     * @return void
     */
    protected function getFilters()
    {
        return $this->request->only($this->filters);
    }
    
}
