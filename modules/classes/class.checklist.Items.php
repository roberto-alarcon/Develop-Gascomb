<?php

    class Items_View extends Items_Form{
        
        var $table;
        var $type_activity;
        var $error_icon     = 'http://mobile-quality.gascomb.com/img/error-icon.png';
        var $select_icon    = 'http://mobile-quality.gascomb.com/img/Select-icon.png';
        var $rate_icon      = 'http://mobile-quality.gascomb.com/img/rate-icon.png';
        
        function activity_ready(){
            
           $checked = ($this->activityready == '1')?$this->select_icon:"";
           
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion que arma elemento con un radio
        function activity_non_ready(){
            
             $checked = ($this->activityready == '2')?$this->error_icon:"";
           
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_1(){
            
            $checked = ($this->rate == '1')?$this->rate_icon:"";
            return '<img src="'.$checked.'">';
            
            
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_2(){
            
            $checked = ($this->rate == '2')?$this->rate_icon:"";
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_3(){
            
            $checked = ($this->rate == '3')?$this->rate_icon:"";
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_4(){
            
            $checked = ($this->rate == '4')?$this->rate_icon:"";
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion que arma elemento con un radio
        function rate_5(){
            
            $checked = ($this->rate == '5')?$this->rate_icon:"";
            return '<img src="'.$checked.'">';
            
        }
        
        // Funcion arma elementos de comentarios
        function comments(){
            /*
            return '<textarea rows="4" cols="50" name="'.$this->table.'_rate_'.$this->item.'"></textarea>
            <input type="hidden" name="'.$this->table.'_control_'.$this->item.'" value="'.$this->table.'_'.$this->item.'" >
            ';
            */
            
            //echo $this->comments;
            return $this->comments;
            
        }
        
        
        
    }
    
    // Clase extendida formularios de pruebas fisicas
    class Items_View_Physical extends Items_View{
        
        function __construct (){
            
            $this->table = 'support_checklist_physical';
            $this->type_activity = 'Fisica';
            
            
        }
               
        
        
    }
    
    // Clase extendida formulario de pruebas mecanicas
    class Items_View_Mechanical extends Items_View{
        
        function __construct (){
            
            $this->table = 'support_checklist_mechanical';
            $this->type_activity = 'Mecanica';
            
        }
        
                
        
        
    }
    
    // Clase extendida formulario de pruebas en pista
    class Items_View_OnRoad extends Items_View{
        
        function __construct (){
            
            $this->table = 'support_checklist_onroad';
            $this->type_activity = 'Pista';
            
        }
        
            
        
    }

?>