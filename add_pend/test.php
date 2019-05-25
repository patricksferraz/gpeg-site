<?php
require_once 'php/controle_acesso/conexao.php';
require_once 'php/controller_write/cgeral.php';

$con = con_db_gpge();

//--------------------------INSERT----------------------------

//------------------------- TESTES ---------------------------
// // USUÁRIOS
// $sql_att = "INSERT INTO usr_usuario (usr_apelido, usr_nome, usr_email, usr_senha) VALUES (?, ?, ?, ?)";
// $data[] = array('psferraz', 'Patrick Silva Ferraz', 'patrick.ferraz@outlook.com', '242bad970400213c5fb4c66580e5647b');
// //$data[] = array('jspfonseca', 'Josefa Sônia Pereira da Fonseca', 'soniafonseca19@gmail.com', '5583413443164b56500def9a533c7c70');
// action($con, $sql_att, $data);
// unset($data);

// // ESCOLAS
// $sql = "INSERT INTO des_dados_escola (des_id_escola, des_nome_escola, des_municipio, des_email) VALUES (?, ?, ?, ?)";
// $dat[] = array(0, 'Escola DEV', 'Itabuna', 'devferraz@gmail.com');
// $dat[] = array(1, 'Escola Patrick', 'Ilhéus', 'patrick536@gmail.com');
// // $dat[] = array(2, 'Escola Sandra', 'Ilhéus', 'sandramagina@gmail.com');
// // $dat[] = array(3, 'Escola Nubia', 'Ilhéus', 'nubia.uesc@gmail.com');
// // $dat[] = array(4, 'Escola Lizandra', 'Ilhéus', 'lizandrasl@yahoo.com.br');
// // $dat[] = array(5, 'Escola Elizabete', 'Ilhéus', 'melizabetesc@gmail.com');
// // $dat[] = array(6, 'Escola Alfedro', 'Ilhéus', 'alfredodib@yahoo.es');
// // $dat[] = array(7, 'Escola Jelarchert', 'Ilhéus', 'jelarchert@yahoo.com.br');
// // $dat[] = array(8, 'Escola Cristavares', 'Ilhéus', 'profacristavares@outlook.com');
// // $dat[] = array(9, 'Escola Delia', 'Ilhéus', 'deliaeducadora@gmail.com');
// // $dat[] = array(10, 'Escola Emilcar', 'Ilhéus', 'emilcarl28@hotmail.com');
// action($con, $sql, $dat);
// unset($dat);

// // NÍVEL FORMAÇÃO
// $sql = "INSERT INTO nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (?, ?)";
// $data[] = array(0, 'Licenciatura');
// $data[] = array(1, 'Bacharelado');
// $data[] = array(2, 'Especialização');
// $data[] = array(3, 'Mestrado');
// $data[] = array(4, 'Mestrando');
// $data[] = array(5, 'Doutor');
// $data[] = array(6, 'Doutorando');
// action($con, $sql, $data);

// unset($data);
// // FAIXA ETÁRIA
// $sql = "INSERT INTO fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (?, ?)";
// $data[] = array(0, 'Até 30 anos');
// $data[] = array(1, '31 a 40 anos');
// $data[] = array(2, '41 a 50 anos');
// $data[] = array(3, '51 a 60 anos');
// $data[] = array(4, 'Mais de 60 anos');
// action($con, $sql, $data);

// unset($data);
// // REDE ESCOLA
// $sql = "INSERT INTO res_rede_escola (res_id_rede_escola, res_des_rede_escola) VALUES (?, ?)";
// $data[] = array('M', 'Municipal');
// $data[] = array('E', 'Estadual');
// $data[] = array('A', 'Municipal e Estadual');
// action($con, $sql, $data);

// unset($data);
// // OBTENÇÃO DE CARGO
// $sql = "INSERT INTO oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (?, ?)";
// $data[] = array(0, 'Concurso público');
// $data[] = array(1, 'Eleição direta');
// $data[] = array(2, 'Seleção técnica');
// $data[] = array(3, 'Indicação política');
// action($con, $sql, $data);

// unset($data);
// // COLABORAÇÃO DO CURSO
// $sql = "INSERT INTO ccu_colaboracao_curso (ccu_id_colaboracao_curso, ccu_des_colaboracao_curso) VALUES (?, ?)";
// $data[] = array('N', 'Não colaboraram');
// $data[] = array('C', 'Colaboraram');
// $data[] = array('P', 'Colaboraram pouco');
// $data[] = array('M', 'Colaboraram muito');
// action($con, $sql, $data);

// unset($data);
// // TEMAS
// $sql = "INSERT INTO tem_tema (tem_id_tema, tem_des_tema) VALUES (?, ?)";
// $data[] = array(0, 'Liderança');
// $data[] = array(1, 'Projeto político pedagógico');
// $data[] = array(2, 'Políticas públicas');
// $data[] = array(3, 'Organizações da aprendizagem');
// $data[] = array(4, 'Tecnologias e aprendizagem');
// $data[] = array(5, 'Financiamento');
// $data[] = array(6, 'Finanças');
// $data[] = array(7, 'Trabalho em equipe');
// $data[] = array(8, 'Noções de administração e legislação');
// $data[] = array(9, 'Cidadania e sustentabilidade');
// $data[] = array(10, 'Gestão participativa e democrática');
// $data[] = array(11, 'Prestação de contas');
// action($con, $sql, $data);

// unset($data);
// // PREPARAÇÃO DA FORMAÇÃO
// $sql = "INSERT INTO pfo_preparacao_formacao (pfo_id_prepacao_formacao, pfo_des_preparacao_formacao) VALUES (?, ?)";
// $data[] = array(0, 'Não preparou');
// $data[] = array(1, 'Preparou pouco');
// $data[] = array(2, 'Preparou');
// $data[] = array(3, 'Preparou muito');
// action($con, $sql, $data);

// unset($data);
// // CURSO
// $sql = "INSERT INTO cur_curso (cur_id_curso, cur_des_curso) VALUES (?, ?)";
// $data[] = array(0, 'Ensino médio');
// $data[] = array(1, 'Curso profissionalizante');
// action($con, $sql, $data);

// unset($data);
// // ESTRUTURA ESCOLA
// $sql = "INSERT INTO ees_estrutura_escola (ees_id_estrutura_escola, ees_des_estrutura_escola) VALUES (?, ?)";
// $data[] = array('P', 'Péssima estrutura física');
// $data[] = array('R', 'Razoável estrutura física');
// $data[] = array('B', 'Boa estrutura física');
// $data[] = array('O', 'Ótima estrutura física');
// action($con, $sql, $data);

// unset($data);
// // SATISFAÇÃO
// $sql = "INSERT INTO sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES (?, ?)";
// $data[] = array('MI', 'Muito insatisfeito');
// $data[] = array('I', 'Insatisfeito');
// $data[] = array('N', 'Neutro');
// $data[] = array('S', 'Satisfeito');
// $data[] = array('MS', 'Muito satisfeito');
// action($con, $sql, $data);

// unset($data);
// // CONSELHO
// $sql = "INSERT INTO con_conselho (con_id_conselho, con_des_conselho) VALUES (?, ?)";
// $data[] = array(0, 'Colegiado escolar');
// $data[] = array(1, 'Associação de pais e mestres');
// action($con, $sql, $data);

// unset($data);
// // AGENTE
// $sql = "INSERT INTO age_agente (age_id_agente, age_des_agente) VALUES (?, ?)";
// $data[] = array(0, 'Aluno');
// $data[] = array(1, 'Família');
// $data[] = array(2, 'Direção escolar');
// $data[] = array(3, 'Professor');
// $data[] = array(4, 'Coordenador pedagógico');
// $data[] = array(5, 'Governo');
// $data[] = array(6, 'Projeto pedagógico da escola');
// $data[] = array(7, 'Merenda escolar');
// $data[] = array(8, 'Bolsa família');
// action($con, $sql, $data);

//-----------------------------------------------------------
//--------------------------EVENTOS---------------------------
//-----------------INSERT NEW EVENT---------------------------
// $data = null;
// $id_evento = 1;
// // INSERT NOVO EVENTO
// $sql = "INSERT INTO eve_evento (
//   eve_id_evento,
//   eve_titulo,
//   eve_data_inicio,
//   eve_data_fim,
//   eve_hora_inicio,
//   eve_hora_fim,
//   eve_data_fim_inscricao,
//   eve_email,
//   eve_telefone,
//   eve_descricao
// ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
// $data[] = array(
//     $id_evento,
//     'I ENCOPEG - ENCONTRO DO GRUPO DE PESQUISA EM EDUCAÇÃO E GESTÃO',
//     '2018-10-23',
//     '2018-10-23',
//     '08:30:00',
//     '17:00:00',
//     '2018-10-22',
//     'gpeg.uesc@gmail.com',
//     null,
//     'O Grupo de Pesquisa de Educação e Gestão (GPEG) do Programa de Pós Graduação em Educação (PPGE), convida os Gestores das Escolas Públicas Estaduais do Estado da Bahia para participar do I Encontro sobre Gestão da Escola.'
// );
// action($con, $sql, $data);

// unset($data);
// // INSERT ENDEREÇO
// $sql = "INSERT INTO end_endereco (
//     end_id_cep,
//     end_rua_av,
//     end_bairro,
//     end_cidade,
//     end_estado
// ) VALUES (?, ?, ?, ?, ?)";
// $data[] = array(
//     '45662-900',
//     'Rodovia Jorge Amado',
//     'Salobrinho',
//     'Ilhéus',
//     'BA'
// );
// action($con, $sql, $data);

// unset($data);
// // INSERT ENDEREÇO EVENTO
// $sql = "INSERT INTO ede_endereco_evento (
//     ede_id_endereco_evento,
//     ede_id_evento,
//     ede_id_cep,
//     ede_numero,
//     ede_pais,
//     ede_complemento
// ) VALUES (?, ?, ?, ?, ?, ?)";
// $data[] = array(
//     1,
//     $id_evento,
//     '45662-900',
//     'km16',
//     'Brasil',
//     'Auditório de Direito (Juizado Modelo), 1º andar do prédio Adonias Filho - Universidade Estadual de Santa Cruz – UESC'
// );
// action($con, $sql, $data);

// unset($data);
// // INSERT ENDEREÇO EVENTO
// $sql = "INSERT INTO pre_pogramacao_evento (
//     pre_id_programacao_evento,
//     pre_id_evento,
//     pre_titulo,
//     pre_descricao,
//     pre_data,
//     pre_hora
// ) VALUES (?, ?, ?, ?, ?, ?)";
// $data[] = array(1, $id_evento, 'Credenciamento', null, '2018-10-23', '08:30:00');
// $data[] = array(2, $id_evento, 'Boas vindas da Coordenação do Projeto', null, '2018-10-23', '09:00:00');
// $data[] = array(3, $id_evento, 'Escola: uma história sem fim', 'Conferência da Profa. Dra. Maria Eduarda Duarte - Profa Catedrática da Universidade de Lisboa.', '2018-10-23', '09:30:00');
// $data[] = array(4, $id_evento, 'Intervalo', null, '2018-10-23', '10:20:00');
// $data[] = array(5, $id_evento, 'Os desafios: o design dos standars de competência: o triangulo (qualidade, transparência e conexão)', null, '2018-10-23', '10:35:00');
// $data[] = array(6, $id_evento, 'Almoço', null, '2018-10-23', '12:00:00');
// $data[] = array(7, $id_evento, 'Grupo de trabalho', 'Os participantes serão agrupados em 5 grupos de 10 pessoas, organizados por Núcleo Territorial de Educação (NTE). Receberão formulário de orientação sobre o que devem trabalhar dentro das dimensões da escola.', '2018-10-23', '13:30:00');
// $data[] = array(8, $id_evento, 'Apresentação do que foi produzido pelos GTs', null, '2018-10-23', '14:30:00');
// $data[] = array(9, $id_evento, 'Intervalo', null, '2018-10-23', '15:30:00');
// $data[] = array(10, $id_evento, 'A gestão e a qualidade dos serviços da escola', 'Conferência da Profa. Dra. Sônia Fonseca', '2018-10-23', '16:00:00');
// $data[] = array(11, $id_evento, 'Encerramento', null, '2018-10-23', '17:00:00');
// action($con, $sql, $data);

//--------------------------DELETE----------------------------
// $sql = "DELETE FROM pge_pesquisa_gestao";
// $stmt = $con->prepare($sql);
// $stmt->execute();

// $sql = "DELETE FROM peq_pesquisa";
// $stmt = $con->prepare($sql);
// $stmt->execute();

// $sql = "DELETE FROM des_dados_escola";
// $stmt = $con->prepare($sql);
// $stmt->execute();
//-----------------------------------------------------------

//--------------------------SELECT---------------------------
// $sql = "SELECT * FROM des_dados_escola";
// $stmt = $con->query($sql);
// $row = $stmt->fetchAll();
// echo "Escolas:<br>";
// foreach ($row as $r){
//     var_dump($r);
//     echo "<br>";
// }

// $sql = "SELECT * FROM peq_pesquisa";
// $stmt = $con->query($sql);
// $row = $stmt->fetchAll();
// echo "Pesquisa:<br>";
// foreach ($row as $r) {
//     var_dump($r);
//     echo "<br>";
// }

// $sql = "SELECT * FROM pge_pesquisa_gestao";
// $stmt = $con->query($sql);
// $row = $stmt->fetchAll();
// echo "Pesquisa Gestão:<br>";

// foreach ($row as $r) {
//     var_dump($r);
//     echo "<br>";

// }
//-----------------------------------------------------------

$con = null;

?>