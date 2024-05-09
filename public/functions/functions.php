<?php


    function asset($path, $base_dir = '') {
        // Se o diretório base não for fornecido, use um valor padrão
        if (empty($base_dir)) {
            // Obtenha o caminho base do diretório do projeto
            $base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/assets/';
        }

        // Combine o diretório base com o caminho do asset
        $url = rtrim($base_dir, '/') . '/' . ltrim($path, '/');

        // Obtenha o caminho base do seu site
        $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $base_url .= "://$_SERVER[HTTP_HOST]";

        // Combine o caminho base com o caminho do asset
        return rtrim($base_url, '/') . $url;
    }

    function create($table, $fields) {
        $pdo = connect();

        if(!is_array($fields)) {
            $fields = (array) $fields;
        }

        $sql = "INSERT INTO {$table}";
        $sql .= "(" . implode(',', array_keys($fields)) . ")";
        $sql .= " VALUES(" . ':' . implode(',:', array_keys($fields)) . ")";

        $insert = $pdo->prepare($sql);
        $success = $insert->execute($fields);

        if (!$success)
            return false;

        $result = find($table, 'id', $pdo->lastInsertId());

        return $result;
    }

    function update($table, $fields, $where) {
        if (!is_array($fields)) {
            $fields = (array) $fields;
        }

        $pdo = connect();

        $data = array_map(function ($field) {
            return "{$field} = :{$field}";
        }, array_keys($fields));

        $sql = "UPDATE {$table} SET ";
        
        $sql .= implode(',', $data);

        $sql .= " WHERE {$where[0]} = :{$where[0]}";

        $data = array_merge($fields, [$where[0] => $where[1]]);

        $update = $pdo->prepare($sql);
        $update->execute($data);

        return $update->rowCount();
    }

    function all($table, $where = null, $operator = '=', $value = null) {
        $pdo = connect();

        $sql = "SELECT * FROM {$table}";

        if($where != null && $operator != null && $value != null) {
            $sql .= " WHERE {$where} {$operator} '{$value}'";
        }
        
        $list = $pdo->query($sql);

        $list->execute();

        return $list->fetchAll();
    }

    function find($table, $field, $value) {
        $pdo = connect();

        $sql = "SELECT * FROM {$table} WHERE {$field} = :{$field}";

        $find = $pdo->prepare($sql);
        $find->bindValue($field, $value);
        $find->execute();

        return $find->fetch();
    }

    function raw($sql, $fetchType = null) {
        $pdo = connect();

        $find = $pdo->query($sql);
        $find->execute();

        if($fetchType == "fetch") {
            return $find->fetch();
        }
        else if($fetchType == "assoc") {
            return $find->fetchAll(PDO::FETCH_ASSOC);
        }

        return $find->fetchAll();
    }
    
    function delete($table, $field, $id) {
        $pdo = connect();

        $sql = "DELETE FROM {$table} WHERE {$field} = :{$field}";
        $delete = $pdo->prepare($sql);
        $delete->bindValue($field, $id);
        return $delete->execute();
    }

    function getMonth($month) {
        switch ($month) {
            case 1:
                return "Janeiro";
            case 2:
                return "Fevereiro";
            case 3:
                return "Março";
            case 4:
                return "Abril";
            case 5:
                return "Maio";
            case 6:
                return "Junho";
            case 7:
                return "Julho";
            case 8:
                return "Agosto";
            case 9:
                return "Setembro";
            case 10:
                return "Outubro";
            case 11:
                return "Novembro";
            case 12:
                return "Dezembro";
        }
    }

    function dd($dump) {
        echo "<pre>";
            var_dump($dump);
        echo "</pre>";
        exit();
    }

    function formatDate($data) {
        // Converte a data para o formato desejado
        $data_formatada = date('d/m/Y', strtotime($data));
        // Retorna a data formatada
        return $data_formatada;
    }

    function daysMissing($data) {
        $data_atual = new DateTime();

        // Data alvo
        $data_alvo_obj = DateTime::createFromFormat('d/m/Y', $data);
        
        // Se a data alvo não pôde ser criada corretamente, retorna uma mensagem de erro
        if (!$data_alvo_obj) {
            return "Erro: Data alvo inválida.";
        }
    
        // Calcula a diferença entre as datas
        $diferenca = $data_atual->diff($data_alvo_obj);
    
        // Retorna o número de dias faltando
        return $diferenca->days;
    }

?>