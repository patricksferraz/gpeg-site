# CRIAÇÃO USUÁRIO
INSERT INTO db_gpge.usr_usuario (usr_apelido, usr_nome, usr_email, usr_senha) VALUES ('psferraz', 'Patrick Silva Ferraz', 'patrick.ferraz@outlook.com', '242bad970400213c5fb4c66580e5647b');

# CRIAÇÃO DA PESQUISA
INSERT INTO db_gpge.peq_pesquisa (peq_id_pesquisa, peq_data_inicio_pesquisa, peq_data_final_pesquisa) VALUES (0, '2018-01-01', '2018-07-17');

# CRIAÇÃO DA ESCOLA
INSERT INTO db_gpge.des_dados_escola (des_id_escola, des_nome_escola, des_municipio, des_email) VALUES (0, 'Escola Teste', 'Itabuna', 'patrick.ferraz@outlook.com');
INSERT INTO db_gpge.des_dados_escola (des_id_escola, des_nome_escola, des_municipio, des_email) VALUES (1, 'Escola Teste 2', 'Ilhéus', 'patrick536@gmail.com');
INSERT INTO db_gpge.des_dados_escola (des_id_escola, des_nome_escola, des_municipio, des_email) VALUES (2, 'Escola Prabhát', 'Ilhéus', 'serra.henrique1@gmail.com');

INSERT INTO db_gpge.pge_pesquisa_gestao (pge_hash_pesquisa, pge_concluido, pge_data_ultima_alteracao, pge_id_pesquisa, pge_id_escola) VALUES ('d41d8cd98f00b204e9800998ecf8427e', 0, null, 0, 0);
INSERT INTO db_gpge.pge_pesquisa_gestao (pge_hash_pesquisa, pge_concluido, pge_data_ultima_alteracao, pge_id_pesquisa, pge_id_escola) VALUES ('d41d8cd98f00b204e9855998ecf8427e', 0, null, 0, 1);

# CRIACAO DA FORMACAO
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 0, 'Matemática');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 1, 'Letras');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 2, 'Educação');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 3, 'Mestrado Fazendo');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 4, 'Mestrado Feito');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 5, 'Doutor Fazendo');
# INSERT INTO db_gpge.fge_formacao_gestor (fge_id_pesquisa_gestao, fge_id_nivel_formacao, fge_des_formacao) VALUES (0, 6, 'Doutor Feito');
#
# INSERT INTO db_gpge.tge_tempo_gestao (tge_id_tempo_gestao, tge_anos, tge_meses) VALUES (0, 3, 2);
# INSERT INTO db_gpge.tge_tempo_gestao (tge_id_tempo_gestao, tge_anos, tge_meses) VALUES (1, 4, 1);
# INSERT INTO db_gpge.peg_perfil_gestor (peg_id_pesquisa_gestao, peg_genero, peg_exerceu_gestao_antes, peg_gestor_qnts_vezes, peg_ch_semanal_gestao, peg_id_faixa_etaria, peg_id_tempo_gestao_atual, peg_id_tempo_gestao_antes, peg_id_rede_escola_antes) VALUES (0, 'M', 1, 3, 20, 0, 0, 1, 'A');
#
# INSERT INTO db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (5, 'Decisão');
# INSERT INTO db_gpge.cge_curso_gestao (cge_id_pesquisa_gestao, cge_quantidade_curso, cge_qual_ultimo, cge_tema_abordado, cge_id_colaboracao_curso) VALUES (0, 6, 'Curso prepatório para academia', 'Administração pública e escolar', 'P');
# INSERT INTO db_gpge.sog_sobre_gestao (sog_id_pesquisa_gestao, sog_participou_curso, sog_temas_desenvolver_gestor, sog_justificativa_preparacao_formacao, sog_caracterizacao_bom_gestor, sog_id_preparacao_formacao, sog_id_obtencao_cargo) VALUES (0, 1, 'Desenvolvimento multicultural da nação e gestão escolar', 'Não preparou da forma adequada pois não ocorreu...', 'Bom gestor se preocupa quanto a formação dos ...', 1, 5);
#
# INSERT INTO db_gpge.aes_acessibilidade_escola (aes_id_pesquisa_gestao, aes_des_acessibilidade) VALUES (0, 'A escola possui rampas, banheiros adaptados ...');
# INSERT INTO db_gpge.ffd_funciona_final_semana (ffd_id_pesquisa_gestao, ffd_quando, ffd_quanto_tempo) VALUES (0, 'Durante o período de ...', 'Até o período de inscrição do ...');
# INSERT INTO db_gpge.pee_perfil_escola (pee_id_pesquisa_gestao, pee_turno_escolar_M, pee_turno_escolar_V, pee_turno_escolar_N, pee_possui_acessibilidade, pee_qnt_alunos, pee_abre_final_semana, pee_id_estrutura_escola) VALUES (0, 1, 1, 1,1, 300, 1, 'R');
#
# INSERT INTO db_gpge.ain_avaliacao_interna (ain_id_pesquisa_gestao, ain_quais) VALUES (0, 'Realizamos as avaliações baseadas');
# INSERT INTO db_gpge.oge_organizacao_gestao_escola (oge_id_pesquisa_gestao, oge_acompanhamento_pedagogico, oge_acoes_pedagogicas, oge_acoes_administrativas, oge_principais_problemas, oge_competencias_diretor, oge_avaliacao_interna, oge_satisfacao_diretor, oge_importancia_diretor, oge_estrategia_melhoria_ideb) VALUES (0, 'Ocorre o acompanhamento pedagogico', 'Ocorre as ações pegagogicas ..', 'ocorre as ações administrativas...', 'os principais problemas são ...', 'As competencias do diretor envolve', 1, 1, 8, 'Para melhoria do ideb pensamos em...');

# DELETE FROM db_gpge.pge_pesquisa_gestao WHERE pge_hash_pesquisa = 'd41d8cd98f00b204e9800998ecf8427e';
# SELECT * FROM db_gpge.pge_pesquisa_gestao;
# UPDATE db_gpge.pge_pesquisa_gestao SET pge_concluido = 0 WHERE pge_id_pesquisa_gestao = 0;
# SELECT * FROM db_gpge.tem_tema LIMIT 12;
# SELECT * FROM db_gpge.tfo_tema_formacao ORDER BY tfo_id_ordem_importancia ASC;

SELECT * FROM db_gpge.pge_pesquisa_gestao;
DELETE FROM db_gpge.pge_pesquisa_gestao;

SELECT * FROM db_gpge.peq_pesquisa;
DELETE FROM db_gpge.peq_pesquisa;

UPDATE db_gpge.peq_pesquisa SET peq_data_final_pesquisa = '2018-05-25';

UPDATE db_gpge.pge_pesquisa_gestao SET pge_concluido = 0 WHERE pge_id_pesquisa_gestao = 1;

SELECT * FROM db_gpge.usr_usuario;

drop database db_gpge;