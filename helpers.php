<?php
/**
 * Get the base path
 * 
 * @param string $path
 * @return string 
 */
function basePath($path = ''){
    $filePath = __DIR__ . '/' . $path;

    return $filePath;
}

/**
 * Load a view 
 * @param string $name
 * @return void
 */
function loadView($name,$data =[]){
    $viewpath = basePath("App/views/{$name}.view.php");
    if(file_exists(($viewpath))){
        extract($data);
        require $viewpath;
    }else{
        echo "View {$name} not found!";
    }

}
/**
 * Load a partial 
 * @param string $name
 * @return void
 */
function loadPartial($name){
    $viewpath = basePath("App/views/partials/{$name}.php");

    if(file_exists(($viewpath))){
        require $viewpath;
    }else{
        echo "View {$name} not found!";
    }
}


/**
 * Inspect a value(s)
 * @param mixed $value
 * @return void
 */
function inspect($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}
/**
 * Inspect a value(s) and die
 * @param mixed $value
 * @return void
 */
function inspectAndDie($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}
/**
 * FORMAT SALARY 
 * @param string $salary
 * @return string Formatted Salary
 * 
 */
function formatSalary($salary){
    return '$'.number_format(floatval($salary));
}