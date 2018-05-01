<?php

// !! ONLY FOR UNIT TESTING !!
class helper_ut {

    static public function val($obj, $property) {
        $rp = new ReflectionProperty($obj, $property);
        $rp->setAccessible(true);
        
        return $rp->getValue($obj);
    }

}
