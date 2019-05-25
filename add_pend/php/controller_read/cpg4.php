<?php

function data_pg4($con, $id)
{
    if ($con) {
        try
        {
            // escola: turno, curso, cargo escola
            $sql = "SELECT pee_turno_escolar_M, pee_turno_escolar_V, pee_turno_escolar_N,
            pee_qnt_alunos, pee_id_estrutura_escola, pee_possui_acessibilidade, aes_des_acessibilidade,
            pee_abre_final_semana, ffd_sabado_m, ffd_sabado_t, ffd_sabado_n, ffd_domingo_m, ffd_domingo_t,
            ffd_domingo_n
                FROM pee_perfil_escola INNER JOIN aes_acessibilidade_escola
                ON pee_id_pesquisa_gestao = aes_id_pesquisa_gestao INNER JOIN ffd_funciona_final_semana
                ON pee_id_pesquisa_gestao = ffd_id_pesquisa_gestao
                WHERE pee_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $data['turno_m'] = $row['pee_turno_escolar_M'];
            $data['turno_v'] = $row['pee_turno_escolar_V'];
            $data['turno_n'] = $row['pee_turno_escolar_N'];
            $data['qnt_aluno'] = $row['pee_qnt_alunos'];
            $data['estrutura_escola'] = $row['pee_id_estrutura_escola'];
            $data['possui_acessibilidade'] = $row['pee_possui_acessibilidade'];
            $data['des_acessibilidade'] = $row['aes_des_acessibilidade'];
            $data['abre_final_semana'] = $row['pee_abre_final_semana'];
            $data['sabado_m'] = $row['ffd_sabado_m'];
            $data['sabado_t'] = $row['ffd_sabado_t'];
            $data['sabado_n'] = $row['ffd_sabado_n'];
            $data['domingo_m'] = $row['ffd_domingo_m'];
            $data['domingo_t'] = $row['ffd_domingo_t'];
            $data['domingo_n'] = $row['ffd_domingo_n'];

            // CURSO ESCOLA
            $sql = "SELECT * FROM ces_curso_escola
                INNER JOIN cur_curso ON ces_id_curso = cur_id_curso
                WHERE ces_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['cursoEscola'] = array();
            foreach ($row as $r)
            {
                if ($r['ces_id_curso'] <= 1)
                    $data['cursoEscola'][$r['ces_id_curso']] = true;
                else
                    $data['cursoEscola']['O'] = $r['cur_des_curso'];
            }

            // CARGO
            $sql = "SELECT * FROM cae_cargo_escola
                WHERE cae_id_pesquisa_gestao = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array('id' => $id));
            $row = $stmt->fetchAll();

            $data['cargo'] = array();
            foreach ($row as $r)
                $data['cargo'][$r['cae_des_cargo']] = array($r['cae_qnt'], $r['cae_id_satisfacao']);

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