<?php

function usfa_user_contact_methods($methods){
    $methods["twitter"]  = __("Twitter" , "user-field-add");
    $methods["facebook"] = __("Facebook" , "user-field-add");
    $methods["linkedIn"] = __("LinkedIn" , "user-field-add");
    return $methods;
}
add_filter("user_contactmethods", "usfa_user_contact_methods");