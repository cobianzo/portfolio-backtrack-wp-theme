<?php

$calculations = Stock_Calculations::calculations_portfolio();

$table = Stock_Frontend::generate_table_html( $calculations, [] );
echo $table;
