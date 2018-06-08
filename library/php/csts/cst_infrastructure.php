<?php

interface cst_infrastructure {

    const app_name   = 'lab'; // APP_NAME
    const valid_page = '/[a-z_0-9\/]*\/([a-z_0-9]+)$/i'; // allow underscore and numbers
    const page       = 'page'; // must match apache2 rewrite rule
    //
    const fail       = 'fail';
    const pass       = 'pass';
    const result     = 'result';

}
