<?php 
    #conexión a la base de datos
    function connection(){
        $pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', '');
        return $pdo;
    }

    #validación de datos
    function validate_data($filter,$text){
		if(preg_match("/^".$filter."$/", $text)){
			return false;
        }else{
            return true;
        }
	}

    #
    function clear_texts($text){
        $text = trim($text);
        $text = stripslashes($text);
        $text = str_ireplace("<script>", "", $text);
        $text = str_ireplace("</script>", "", $text);
        $text = str_ireplace("<script src>", "", $text);
        $text = str_ireplace("<script type>", "", $text);
        $text = str_ireplace("SELECT * FROM", "", $text);
        $text = str_ireplace("DELETE FROM", "", $text);
        $text = str_ireplace("INSERT INTO", "", $text);
        $text = str_ireplace("DROP TABLE", "", $text);
        $text = str_ireplace("DROP DATABASE", "", $text);
        $text = str_ireplace("TRUNCATE TABLE", "", $text);
        $text = str_ireplace("SHOW TABLES", "", $text);
        $text = str_ireplace("SHOW DATABASES", "", $text);
        $text = str_ireplace("<?php", "", $text);
        $text = str_ireplace("<?", "", $text);
        $text = str_ireplace("--", "", $text);
        $text = str_ireplace("^", "", $text);
        $text = str_ireplace("<", "", $text);
        $text = str_ireplace("[", "", $text);
        $text = str_ireplace("]", "", $text);
        $text = str_ireplace("==", "", $text);
        $text = str_ireplace(";", "", $text);
        $text = str_ireplace("::", "", $text);
        $text = trim($text);
        $text = stripslashes($text);
        return $text;
    }

    #renombrar fotos
    function rename_photo($name) {
        $name = str_replace(" ", "_", $name);
        $name = str_replace("-", "_", $name);
        $name = str_replace("/", "_", $name);
        $name = str_replace("#", "_", $name);
        $name = str_replace("$", "_", $name);
        $name = str_replace(".", "_", $name);
        $name = str_replace(",", "_", $name);
        $name = $name."_".rand(0,100);
        return $name;
    }

    function pagination($page, $total_pages, $url, $buttons){
        $table = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';
        
        if ($page <= 1) {
            $table .= ' <a class="pagination-previous is-disabled" disabled >Anterior</a>
			    <ul class="pagination-list">';
        }else {
            $table .= ' <a class="pagination-previous" href="'.$url.($page-1).'">Anterior</a>
                <ul class="pagination-list">
                    <li>
                    <a class="pagination-link" href="'.$url.'1">1</a>
                    </li>
            ';
            
        }
        
        $ci = 0;
        for ($i = $page; $i <= $total_pages; $i++) { 
            if( $ci == $buttons ) break; 
            
            if ($page == $i) {
                $table .= '<li>
                    <a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a>
                </li>
                ';
            }else {
                $table .= '<li>
                    <a class="pagination-link" href="'.$url.$i.'">'.$i.'</a>
                </li>';
            }
            $ci++;
        }
        
        if ($page == $total_pages) {
            $table .= '</ul>
            <a class="pagination-next is-disabled" disabled >Siguiente </a>
            ';
        }else {
            $table .= ' </ul>
                <a class="pagination-next" href="'.$url.($page + 1).'" >Siguiente </a>
            ';
            
        }
        
        $table .= '</nav>';
        return $table;
    }