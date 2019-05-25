<?php

function validar_hash($con, $hash)
{
	if ($con)
	{
		try 
		{
	
			$sql = "SELECT * FROM pge_pesquisa_gestao
				INNER JOIN peq_pesquisa ON peq_id_pesquisa = pge_id_pesquisa
				WHERE pge_hash_pesquisa = :hash";
			$stmt = $con->prepare($sql);
			$stmt->execute(array('hash' => $hash));
			$qt_row = $stmt->rowCount();
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
			$return = array();
	
			if ($qt_row)
			{
				//$hoje = date('Y-m-d');
				$id = $row['pge_id_pesquisa_gestao'];
				$concluido = $row['pge_concluido'];
				$data_final = $row['peq_data_final_pesquisa'];
				//if (!$concluido && ($hoje <= $data_final))
					$return = array('flag' => 0, 'id' => $id, 'concluido' => $concluido, 'data_final' => $data_final);
			}
			
			$stmt = $row = null;
	
			return $return;
	
		}
		catch (Exception $e) 
		{
	
			return array('flag' => 1, 'erro' => $e);
			
		}
	}
	else
	{
		return false;
	}
}

?>