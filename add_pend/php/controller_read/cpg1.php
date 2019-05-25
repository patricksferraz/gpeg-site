<?php

function data_pg1 ($con, $id)
{
    if ($con) {
        try
        {

            $sql = "SELECT des_nome_escola, des_municipio
                FROM des_dados_escola INNER JOIN pge_pesquisa_gestao
                ON des_id_escola = pge_id_escola
                WHERE pge_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $data['nome_escola'] = $row['des_nome_escola'];
            $data['municipio'] = $row['des_municipio'];

			$sql = "SELECT * FROM fge_formacao_gestor
                WHERE fge_id_pesquisa_gestao = :id";
			$stmt = $con->prepare($sql);
			$stmt->execute(array('id' => $id));
			$row = $stmt->fetchAll();

            // 0 'Licenciatura' 1 'Bacharelado' 2 'Especialização'
            // 3 'Mestrado' 4 'Mestrando' 5 'Doutor' 6 'Doutorando'
			foreach ($row as $r) {
				$data[$r['fge_id_nivel_formacao']] = $r['fge_des_formacao'];
			}

            $stmt = $row = null;

            return $data;

        } catch (Exception $e) {

            return array();

        }
    } else {
        return array();
    }

}
?>