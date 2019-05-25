############################################ CREATE DO BANCO DE DADOS ############################################
CREATE DATABASE db_gpge CHARSET = UTF8 COLLATE = utf8_general_ci;

#DROP DATABASE db_gpge;

############################################ CREATE DAS TABELAS ############################################

###################### TABELAS PÁGINA 1 E GERAL ######################

-- DADOS DOS USUÁRIOS
CREATE TABLE db_gpge.usr_usuario (
  usr_id_usuario  INT NOT NULL, -- NEW PK
  usr_apelido     VARCHAR(25) NOT NULL, -- ANTERIOR PK
  usr_nome        VARCHAR(255) NOT NULL,
  usr_email       VARCHAR(100) NOT NULL,
  usr_senha       VARCHAR(50) NOT NULL,
  CONSTRAINT pk_usr PRIMARY KEY (usr_id_usuario),
  CONSTRAINT un_usr UNIQUE(usr_apelido, usr_email) -- NEW CONSTRAINT
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS GERAIS DA ESCOLA (PG 1)
CREATE TABLE db_gpge.des_dados_escola (
  des_id_escola   INT NOT NULL,
  des_nome_escola VARCHAR(255),
  des_municipio   VARCHAR(100),
  des_email       VARCHAR(100),
  CONSTRAINT pk_des PRIMARY KEY (des_id_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS DA PESQUISA
CREATE TABLE db_gpge.peq_pesquisa (
  peq_id_pesquisa           INT NOT NULL,
  peq_data_inicio_pesquisa  DATE NOT NULL,
  peq_data_final_pesquisa   DATE NOT NULL,
  CONSTRAINT pk_peq     PRIMARY KEY (peq_id_pesquisa)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS DA PESQUISA REQUISITADA
CREATE TABLE db_gpge.pge_pesquisa_gestao (
  pge_id_pesquisa_gestao    INT NOT NULL AUTO_INCREMENT,
  pge_hash_pesquisa         VARCHAR(50) NOT NULL,
  pge_concluido             BOOL NOT NULL,
  pge_data_ultima_alteracao DATETIME,
  pge_id_pesquisa           INT NOT NULL,
  pge_id_escola             INT NOT NULL,
  CONSTRAINT pk_pge     PRIMARY KEY (pge_id_pesquisa_gestao),
  CONSTRAINT fk_pge_peq FOREIGN KEY (pge_id_pesquisa)
    REFERENCES db_gpge.peq_pesquisa (peq_id_pesquisa),
  CONSTRAINT fk_pge_des FOREIGN KEY (pge_id_escola)
    REFERENCES db_gpge.des_dados_escola (des_id_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS NÍVEL FORMAÇÃO
-- 0 Licenciatura, 1 Bacharelado, 2 Especialização, 3 Mestrado, 4 Mestrando, 5 Doutor, 6 Doutorando
CREATE TABLE db_gpge.nfo_nivel_formacao (
  nfo_id_nivel_formacao   INT NOT NULL,
  nfo_des_nivel_formacao  VARCHAR(50),
  CONSTRAINT pk_nfo PRIMARY KEY (nfo_id_nivel_formacao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS DA FORMAÇÃO DO GESTOR (PG 1)
CREATE TABLE db_gpge.fge_formacao_gestor (
  fge_id_pesquisa_gestao  INT NOT NULL,
  fge_id_nivel_formacao   INT,
  fge_des_formacao        VARCHAR(255),
  CONSTRAINT pk_fge     PRIMARY KEY (fge_id_pesquisa_gestao, fge_id_nivel_formacao),
  CONSTRAINT fk_fge_pge FOREIGN KEY (fge_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_fge_nfo FOREIGN KEY (fge_id_nivel_formacao)
    REFERENCES db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

###################### TABELAS NA PÁGINA 2 ######################

-- DADOS TEMPO DE GESTÃO (PG 2)
CREATE TABLE db_gpge.tge_tempo_gestao (
  tge_id_tempo_gestao INT NOT NULL,
  tge_anos            INT(3),
  tge_meses           INT(3),
  CONSTRAINT pk_tge PRIMARY KEY (tge_id_tempo_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS FAIXA ETÁRIA (PG 2)
-- 0 Até 30 anos; 1 31 a 40 anos; 2 41 a 50 anos; 3 51 a 60 anos; 4 Mais de 60 anos
CREATE TABLE db_gpge.fet_faixa_etaria (
  fet_id_faixa_etaria   INT NOT NULL,
  fet_des_faixa_etaria  VARCHAR(50),
  CONSTRAINT pk_fet PRIMARY KEY (fet_id_faixa_etaria)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS DA REDE ESCOLA (PG 2)
-- M Municipal; E Estadual; A Municipal e Estadual
CREATE TABLE db_gpge.res_rede_escola (
  res_id_rede_escola   CHAR(1) NOT NULL,
  res_des_rede_escola  VARCHAR(50),
  CONSTRAINT pk_res PRIMARY KEY (res_id_rede_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS DO GESTOR (PG 2)
CREATE TABLE db_gpge.peg_perfil_gestor(
  peg_id_pesquisa_gestao    INT NOT NULL,
  peg_genero                CHAR(1), # M Masculino, F Feminino
  peg_exerceu_gestao_antes  BOOL,
  peg_gestor_qnts_vezes     INT(3),
  peg_ch_semanal_gestao     INT(3),
  peg_id_faixa_etaria       INT,
  peg_id_tempo_gestao_atual INT,
  peg_id_tempo_gestao_antes INT,
  peg_id_rede_escola_antes  CHAR(1),
  CONSTRAINT pk_peg           PRIMARY KEY (peg_id_pesquisa_gestao),
  CONSTRAINT fk_peg           FOREIGN KEY (peg_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_peg_fet       FOREIGN KEY (peg_id_faixa_etaria)
    REFERENCES db_gpge.fet_faixa_etaria (fet_id_faixa_etaria),
  CONSTRAINT fk_peg_tge_atual FOREIGN KEY (peg_id_tempo_gestao_atual)
    REFERENCES db_gpge.tge_tempo_gestao (tge_id_tempo_gestao),
  CONSTRAINT fk_peg_tge_antes FOREIGN KEY (peg_id_tempo_gestao_antes)
    REFERENCES db_gpge.tge_tempo_gestao (tge_id_tempo_gestao),
  CONSTRAINT fk_peg_res       FOREIGN KEY (peg_id_rede_escola_antes)
    REFERENCES db_gpge.res_rede_escola (res_id_rede_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

###################### TABELAS DA PÁGINA 3 ######################

-- DADOS OBTENCAO DE CARGO (PG 3)
-- 0 Concurso Público, 1 Eleição Direta, 2 Seleção Técnica, 3 Indicação Política, - Outros
CREATE TABLE db_gpge.oca_obtencao_cargo (
  oca_id_obtencao_cargo   INT NOT NULL,
  oca_des_obtencao_cargo  VARCHAR(50),
  CONSTRAINT pk_oca PRIMARY KEY (oca_id_obtencao_cargo)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS COLABORAÇÃO DO CURSO (PG 3)
-- N Não colaboraram; C Colaboraram; P Colaboraram pouco; M Colaboraram muito
CREATE TABLE db_gpge.ccu_colaboracao_curso (
  ccu_id_colaboracao_curso  CHAR(1) NOT NULL,
  ccu_des_colaboracao_curso VARCHAR(50),
  CONSTRAINT pk_ccu PRIMARY KEY (ccu_id_colaboracao_curso)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS CURSO GESTÂO (PG 3)
CREATE TABLE db_gpge.cge_curso_gestao (
  cge_id_pesquisa_gestao    INT NOT NULL,
  cge_quantidade_curso      INT(3),
  cge_quando_ultimo         INT(4),
  cge_qual_ultimo           VARCHAR(500),
  cge_tema_abordado         VARCHAR(500),
  cge_id_colaboracao_curso  CHAR(1),
  CONSTRAINT pk_cge     PRIMARY KEY (cge_id_pesquisa_gestao),
  CONSTRAINT fk_cge_pge FOREIGN KEY (cge_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_cge_ccu FOREIGN KEY (cge_id_colaboracao_curso)
    REFERENCES db_gpge.ccu_colaboracao_curso (ccu_id_colaboracao_curso)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS TEMAS (PG 3)
CREATE TABLE db_gpge.tem_tema (
  tem_id_tema   INT NOT NULL,
  tem_des_tema  VARCHAR(100),
  CONSTRAINT pk_tem PRIMARY KEY (tem_id_tema)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS TEMAS FORMAÇÃO (PG 3)
CREATE TABLE db_gpge.tfo_tema_formacao (
  tfo_id_pesquisa_gestao    INT NOT NULL,
  tfo_id_tema               INT NOT NULL,
  CONSTRAINT pk_tfo     PRIMARY KEY (tfo_id_pesquisa_gestao, tfo_id_tema),
  CONSTRAINT fk_tfo_pge FOREIGN KEY (tfo_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT tk_tfo_tem FOREIGN KEY (tfo_id_tema)
    REFERENCES db_gpge.tem_tema (tem_id_tema)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS TEMAS FORMAÇÃO DESENVOLVIMENTO (PG 3)
CREATE TABLE db_gpge.tfd_tema_formacao_desenvolvimento (
  tfd_id_pesquisa_gestao    INT NOT NULL,
  tfd_id_ordem_importancia  INT NOT NULL,
  tfd_id_tema               INT NOT NULL,
  CONSTRAINT pk_tfd     PRIMARY KEY (tfd_id_pesquisa_gestao, tfd_id_ordem_importancia),
  CONSTRAINT fk_tfd_pge FOREIGN KEY (tfd_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_tfd_tem FOREIGN KEY (tfd_id_tema)
    REFERENCES db_gpge.tem_tema (tem_id_tema)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS PREPARAÇÃO FORMAÇÃO (PG 3)
-- 0 Não preparou, 1 Preparou pouco, 2 Preparou, 3 Preparou muito
CREATE TABLE db_gpge.pfo_preparacao_formacao (
  pfo_id_prepacao_formacao    INT NOT NULL,
  pfo_des_preparacao_formacao VARCHAR(50),
  CONSTRAINT pk_pfo PRIMARY KEY (pfo_id_prepacao_formacao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS SOBRE A GESTÃO (PG 3)
CREATE TABLE db_gpge.sog_sobre_gestao(
  sog_id_pesquisa_gestao                INT NOT NULL,
  sog_participou_curso                  BOOL,
  sog_temas_desenvolver_gestor          VARCHAR(1000),
  sog_justificativa_preparacao_formacao VARCHAR(1000),
  sog_caracterizacao_bom_gestor         VARCHAR(1000),
  sog_id_preparacao_formacao            INT,
  sog_id_obtencao_cargo                 INT,
  CONSTRAINT pk_sog     PRIMARY KEY (sog_id_pesquisa_gestao),
  CONSTRAINT fk_sog_pge FOREIGN KEY (sog_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_sog_pfo FOREIGN KEY (sog_id_preparacao_formacao)
    REFERENCES db_gpge.pfo_preparacao_formacao (pfo_id_prepacao_formacao),
  CONSTRAINT fk_sog_oca FOREIGN KEY (sog_id_obtencao_cargo)
    REFERENCES db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

###################### TABELAS DA PÁGINA 4 ######################

-- DADOS CURSO (PG 4)
CREATE TABLE db_gpge.cur_curso (
  cur_id_curso  INT NOT NULL,
  cur_des_curso VARCHAR(50),
  CONSTRAINT pk_cur PRIMARY KEY (cur_id_curso)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS CURSO ESCOLA (PG 4)
CREATE TABLE db_gpge.ces_curso_escola (
  ces_id_pesquisa_gestao  INT NOT NULL,
  ces_id_curso            INT NOT NULL,
  CONSTRAINT pk_ces PRIMARY KEY (ces_id_pesquisa_gestao, ces_id_curso)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS ESTRUTURA ESCOLA (PG 4)
-- O 'Ótima estrutura física' R 'Razoável estrutura física' B 'Boa estrutura física' P 'Péssima estrutura física'
CREATE TABLE db_gpge.ees_estrutura_escola (
  ees_id_estrutura_escola   CHAR(1) NOT NULL,
  ees_des_estrutura_escola  VARCHAR(50),
  CONSTRAINT pk_ees PRIMARY KEY (ees_id_estrutura_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS ACESSIBILIDADE ESCOLA (PG 4)
CREATE TABLE db_gpge.aes_acessibilidade_escola (
  aes_id_pesquisa_gestao  INT NOT NULL,
  aes_des_acessibilidade  VARCHAR(1000),
  CONSTRAINT pk_aes PRIMARY KEY (aes_id_pesquisa_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS SATISFAÇÃO (PG 4)
-- Muito satisfeiro(MS) | Satisfeito(S) | Neutro(N) | Insatisfeito(I) | Muito Insatisfeito(MI)
CREATE TABLE db_gpge.sat_satisfacao (
  sat_id_satisfacao   CHAR(2) NOT NULL,
  sat_des_satisfacao  VARCHAR(50),
  CONSTRAINT pk_sat PRIMARY KEY (sat_id_satisfacao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS CARGO ESCOLA (PG 4)
CREATE TABLE db_gpge.cae_cargo_escola (
  cae_id_pesquisa_gestao  INT NOT NULL,
  cae_des_cargo           VARCHAR(50),
  cae_qnt                 INT(3),
  cae_id_satisfacao       CHAR(2),
  CONSTRAINT pk_cae     PRIMARY KEY (cae_id_pesquisa_gestao, cae_des_cargo),
  CONSTRAINT fk_cae_pge FOREIGN KEY (cae_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT pk_cae_sat FOREIGN KEY (cae_id_satisfacao)
    REFERENCES db_gpge.sat_satisfacao (sat_id_satisfacao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS FUNCIONA FINAL SEMANA (PG 4)
CREATE TABLE db_gpge.ffd_funciona_final_semana (
  ffd_id_pesquisa_gestao  INT NOT NULL,
  ffd_sabado_m            BOOL,
  ffd_sabado_t            BOOL,
  ffd_sabado_n            BOOL,
  ffd_domingo_m           BOOL,
  ffd_domingo_t           BOOL,
  ffd_domingo_n           BOOL,
  CONSTRAINT pk_ffd     PRIMARY KEY (ffd_id_pesquisa_gestao),
  CONSTRAINT fk_ffd_pge FOREIGN KEY (ffd_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS PERFIL ESCOLA (PG 4)
CREATE TABLE db_gpge.pee_perfil_escola(
  pee_id_pesquisa_gestao      INT NOT NULL,
  pee_turno_escolar_M         BOOL,
  pee_turno_escolar_V         BOOL,
  pee_turno_escolar_N         BOOL,
  pee_possui_acessibilidade   BOOL,
  pee_qnt_alunos              INT(6),
  pee_abre_final_semana       BOOL,
  pee_id_estrutura_escola     CHAR(1),
  CONSTRAINT pk_pee     PRIMARY KEY (pee_id_pesquisa_gestao),
  CONSTRAINT fk_pee_pge FOREIGN KEY (pee_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_pee_ees FOREIGN KEY (pee_id_estrutura_escola)
    REFERENCES db_gpge.ees_estrutura_escola (ees_id_estrutura_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

###################### TABELAS DA PÁGINA 5 ######################

-- DADOS AVALIACAO INTERNA (PG 5)
CREATE TABLE db_gpge.ain_avaliacao_interna (
  ain_id_pesquisa_gestao  INT NOT NULL,
  ain_quais               VARCHAR(1000),
  CONSTRAINT pk_ain     PRIMARY KEY (ain_id_pesquisa_gestao),
  CONSTRAINT fk_ain_pge FOREIGN KEY (ain_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS CONSELHO (PG 5)
CREATE TABLE db_gpge.con_conselho (
  con_id_conselho  INT NOT NULL,
  con_des_conselho VARCHAR(100),
  CONSTRAINT pk_con PRIMARY KEY (con_id_conselho)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS CONSELHO ESCOLAR (PG 5)
CREATE TABLE db_gpge.coe_conselho_escola (
  coe_id_pesquisa_gestao  INT NOT NULL,
  coe_id_conselho         INT NOT NULL,
  CONSTRAINT pk_coe     PRIMARY KEY (coe_id_pesquisa_gestao, coe_id_conselho),
  CONSTRAINT fk_coe_pge FOREIGN KEY (coe_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_coe_con FOREIGN KEY (coe_id_conselho)
    REFERENCES db_gpge.con_conselho (con_id_conselho)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS AGENTE (PG 5)
CREATE TABLE db_gpge.age_agente (
  age_id_agente  INT NOT NULL,
  age_des_agente VARCHAR(100),
  CONSTRAINT pk_age     PRIMARY KEY (age_id_agente)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS BAIXO RENDIMENTO (PG 5)
CREATE TABLE db_gpge.bre_baixo_rendimento (
  bre_id_pesquisa_gestao    INT NOT NULL,
  bre_id_ordem_importancia  INT NOT NULL,
  bre_id_agente             INT NOT NULL,
  CONSTRAINT pk_bre     PRIMARY KEY (bre_id_pesquisa_gestao, bre_id_ordem_importancia),
  CONSTRAINT fk_bre_pge FOREIGN KEY (bre_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_bre_res FOREIGN KEY (bre_id_agente)
    REFERENCES db_gpge.age_agente (age_id_agente)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS NOTA IDEB (PG 5)
CREATE TABLE db_gpge.nid_nota_ideb (
  nid_id_pesquisa_gestao  INT NOT NULL,
  nid_ano                 YEAR NOT NULL,
  nid_nota                INT(3),
  CONSTRAINT pk_nid     PRIMARY KEY (nid_id_pesquisa_gestao, nid_ano),
  CONSTRAINT fk_nid_pge FOREIGN KEY (nid_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

-- DADOS ORGANIZAÇÃO GESTÃO ESCOLA (PG 5)
CREATE TABLE db_gpge.oge_organizacao_gestao_escola (
  oge_id_pesquisa_gestao        INT NOT NULL,
  oge_acompanhamento_pedagogico VARCHAR(1000),
  oge_acoes_pedagogicas         VARCHAR(1000),
  oge_acoes_administrativas     VARCHAR(1000),
  oge_principais_problemas      VARCHAR(1000),
  oge_competencias_diretor      VARCHAR(1000),
  oge_avaliacao_interna         BOOL,
  oge_importancia_diretor       INT(3),
  oge_estrategia_melhoria_ideb  VARCHAR(1000),
  CONSTRAINT pk_oge PRIMARY KEY (oge_id_pesquisa_gestao)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

############################################ EVENTOS #############################################
# ATUALIZAÇÃO 18/09/2018

CREATE TABLE db_gpge.pes_pessoa (
  pes_id_pessoa INT NOT NULL,
  pes_nome      VARCHAR(50) NOT NULL,
  pes_sobrenome VARCHAR(255) NOT NULL,
  pes_formacao  VARCHAR(255),
  pes_cpf       VARCHAR(50),
  pes_rg        VARCHAR(50),
  pes_email     VARCHAR(255) NOT NULL,
  pes_validado  BOOLEAN,
  CONSTRAINT pk_pessoa PRIMARY KEY (pes_id_pessoa)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.tep_telefone_pessoa (
  tep_id_pessoa INT NOT NULL,
  tep_telefone  VARCHAR(50) NOT NULL,
  CONSTRAINT pk_tep     PRIMARY KEY (tep_id_pessoa, tep_telefone),
  CONSTRAINT fk_tep_pes FOREIGN KEY (tep_id_pessoa)
    REFERENCES db_gpge.pes_pessoa (pes_id_pessoa)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.end_endereco (
  end_id_cep        VARCHAR(50) NOT NULL,
  end_rua_av        VARCHAR(255),
  end_bairro        VARCHAR(255),
  end_cidade        VARCHAR(150),
  end_estado        VARCHAR(100),
  CONSTRAINT pk_end PRIMARY KEY (end_id_cep)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.enp_endereco_pessoa (
  enp_id_endereco_pessoa  INT NOT NULL,
  enp_id_pessoa           INT NOT NULL,
  enp_id_cep              VARCHAR(50) NOT NULL,
  enp_numero              VARCHAR(10) NOT NULL,
  enp_pais                VARCHAR(100) NOT NULL,
  enp_complemento         VARCHAR(255),
  CONSTRAINT pk_enp     PRIMARY KEY (enp_id_endereco_pessoa),
  CONSTRAINT fk_enp_pes FOREIGN KEY (enp_id_pessoa)
    REFERENCES db_gpge.pes_pessoa (pes_id_pessoa),
  CONSTRAINT fk_enp_end FOREIGN KEY (enp_id_cep)
    REFERENCES db_gpge.end_endereco (end_id_cep)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.eve_evento (
  eve_id_evento           INT NOT NULL,
  eve_titulo              VARCHAR(500) NOT NULL,
  eve_data_inicio         DATE NOT NULL,
  eve_data_fim            DATE,
  eve_hora_inicio         TIME NOT NULL,
  eve_hora_fim            TIME,
  eve_data_fim_inscricao  DATE NOT NULL,
  eve_email               VARCHAR(255),
  eve_telefone            VARCHAR(50),
  eve_descricao           VARCHAR(5000) NOT NULL,
  CONSTRAINT pk_eve PRIMARY KEY (eve_id_evento)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.ede_endereco_evento (
  ede_id_endereco_evento  INT NOT NULL,
  ede_id_evento           INT NOT NULL,
  ede_id_cep              VARCHAR(50) NOT NULL,
  ede_numero              VARCHAR(10) NOT NULL,
  ede_pais                VARCHAR(100) NOT NULL,
  ede_complemento         VARCHAR(255),
  CONSTRAINT pk_ede     PRIMARY KEY (ede_id_endereco_evento),
  CONSTRAINT fk_ede_eve FOREIGN KEY (ede_id_evento)
    REFERENCES db_gpge.eve_evento (eve_id_evento),
  CONSTRAINT fk_ede_end FOREIGN KEY (ede_id_cep)
    REFERENCES db_gpge.end_endereco (end_id_cep)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.pre_pogramacao_evento (
  pre_id_programacao_evento INT NOT NULL,
  pre_id_evento             INT NOT NULL,
  pre_titulo                VARCHAR(255) NOT NULL,
  pre_descricao             VARCHAR(2000),
  pre_data                  DATE NOT NULL,
  pre_hora                  TIME NOT NULL,
  CONSTRAINT pk_pre     PRIMARY KEY (pre_id_programacao_evento),
  CONSTRAINT fk_pre_eve FOREIGN KEY (pre_id_evento)
    REFERENCES db_gpge.eve_evento (eve_id_evento)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.ine_inscrito_evento (
  ine_id_inscrito_evento INT NOT NULL,
  ine_id_pessoa          INT NOT NULL,
  ine_id_evento          INT NOT NULL,
  ine_apelido            VARCHAR(100),
  ine_data_inscricao     DATETIME NOT NULL,
  CONSTRAINT pk_ine     PRIMARY KEY (ine_id_inscrito_evento),
  CONSTRAINT fk_ine_pes FOREIGN KEY (ine_id_pessoa)
    REFERENCES db_gpge.pes_pessoa (pes_id_pessoa),
  CONSTRAINT fk_ine_eve FOREIGN KEY (ine_id_evento)
    REFERENCES db_gpge.eve_evento (eve_id_evento)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.iep_inscrito_evento_pesquisa (
  iep_id_inscrito_evento      INT NOT NULL,
  iep_id_escola_pessoa        INT,
  iep_respondeu_pesquisa      BOOLEAN NOT NULL,
  iep_temas_curso_preferencia VARCHAR(1000),
  CONSTRAINT pk_iep     PRIMARY KEY (iep_id_inscrito_evento),
  CONSTRAINT pk_iep_ine FOREIGN KEY (iep_id_inscrito_evento)
    REFERENCES db_gpge.ine_inscrito_evento (ine_id_inscrito_evento),
  CONSTRAINT fk_iep_esc FOREIGN KEY (iep_id_escola_pessoa)
    REFERENCES db_gpge.des_dados_escola (des_id_escola)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

## EDIÇÃO DA TABELA DE USUARIO
## 13/10/2018
# ALTER TABLE db_gpge.usr_usuario ADD CONSTRAINT un_usr UNIQUE (usr_apelido, usr_email);
# ALTER TABLE db_gpge.usr_usuario DROP PRIMARY KEY;
# ALTER TABLE db_gpge.usr_usuario ADD COLUMN usr_id_usuario INT NOT NULL FIRST;
# ALTER TABLE db_gpge.usr_usuario ADD CONSTRAINT pk_usr PRIMARY KEY (usr_id_usuario);

############################################ HISTORICO #############################################
# ATUALIZAÇÃO 13/10/2018

CREATE TABLE db_gpge.men_mensagem (
  men_id_mensagem INT NOT NULL,
  men_assunto     VARCHAR(100),
  men_mensagem    VARCHAR(10000),
  CONSTRAINT pk_men PRIMARY KEY (men_id_mensagem)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.lmp_log_mensagem_pesquisa (
  lmp_id_log_mensagem_pesquisa INT NOT NULL AUTO_INCREMENT,
  lmp_data_envio               DATETIME NOT NULL,
  lmp_lembrete_pesquisa        BOOLEAN,
  lmp_enviado                  BOOLEAN,
  lmp_id_mensagem              INT NOT NULL,
  lmp_id_pesquisa_gestao       INT NOT NULL,
  lmp_id_usuario_enviou        INT NOT NULL,
  CONSTRAINT pk_hme     PRIMARY KEY (lmp_id_log_mensagem_pesquisa),
  CONSTRAINT fk_hme_men FOREIGN KEY (lmp_id_mensagem)
    REFERENCES db_gpge.men_mensagem (men_id_mensagem),
  CONSTRAINT fk_hme_pge FOREIGN KEY (lmp_id_pesquisa_gestao)
    REFERENCES db_gpge.pge_pesquisa_gestao (pge_id_pesquisa_gestao),
  CONSTRAINT fk_hme_usr FOREIGN KEY (lmp_id_usuario_enviou)
    REFERENCES db_gpge.usr_usuario (usr_id_usuario)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

CREATE TABLE db_gpge.lac_log_acesso (
  lac_id_log_acesso       INT NOT NULL AUTO_INCREMENT,
  lac_data_acesso         DATETIME NOT NULL,
  lac_id_usuario          INT NOT NULL,
  CONSTRAINT pk_hac     PRIMARY KEY (lac_id_log_acesso),
  CONSTRAINT fk_hac_usr FOREIGN KEY (lac_id_usuario)
    REFERENCES db_gpge.usr_usuario (usr_id_usuario)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_bin;

############################################ GERAR RESULTADOS #############################################
# ATUALIZAÇÃO 20/10/2018

-- QUANTIDADE DE PESQUISAS
# SELECT COUNT(*) FROM db_gpge.pge_pesquisa_gestao;
-- NIVEL FORMAÇÃO
# SELECT sub.nfo_des_nivel_formacao AS 'Formação', COUNT(sub.nfo_des_nivel_formacao) AS 'Quantidade'
#   FROM (SELECT * FROM db_gpge.fge_formacao_gestor FULL JOIN db_gpge.nfo_nivel_formacao
#           ON nfo_id_nivel_formacao = fge_id_nivel_formacao WHERE fge_des_formacao <> "") sub
#   GROUP BY sub.nfo_des_nivel_formacao;
-- GENERO
# SELECT COUNT(peg_genero),
#        CASE peg_genero
#            WHEN 'M' THEN 'Masculino'
#            WHEN 'F' THEN 'Feminino'

SELECT pge_id_pesquisa_gestao AS 'Id pesquisa gestão',
       des_nome_escola AS 'Nome escola',
       GROUP_CONCAT(nfo_des_nivel_formacao ORDER BY pge_id_pesquisa_gestao, ', ') AS 'Grau formação gestor',
       GROUP_CONCAT(fge_des_formacao ORDER BY pge_id_pesquisa_gestao, ', ') AS 'Formação',
       peg_genero AS 'Gênero gestor',
       fet_des_faixa_etaria AS 'Faixa etária gestor',
       CASE peg_exerceu_gestao_antes
           WHEN 0 THEN 'Não'
           WHEN 1 THEN 'Sim'
       END AS 'Exerceu gestão antes?',
       res_des_rede_escola AS 'Rede escolar anterior',
       peg_gestor_qnts_vezes AS 'Por quantas vezes foi gestor antes?',
       peg_ch_semanal_gestao AS 'CH semanal para o desenvolvimento das funções do gestor?',
       oca_des_obtencao_cargo AS 'Como obteve o cargo?',
       CASE sog_participou_curso
           WHEN 0 THEN 'Não'
           WHEN 1 THEN 'Sim'
       END AS 'Participou de algum curso de gestão com mais de 40h?',
       cge_quantidade_curso AS 'Quantidade de cursos que participou',
       cge_quando_ultimo AS 'Ano do último curso',
       ccu_des_colaboracao_curso AS 'Esse(s) curso(s) colaborou para formação?',
       pfo_des_preparacao_formacao AS 'O curso de graduação/licenciatura preparou para gestão?',
       CASE pee_turno_escolar_M
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno matutino?',
       CASE pee_turno_escolar_V
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno vespertino?',
       CASE pee_turno_escolar_N
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Funciona no turno noturno?',
       pee_qnt_alunos AS 'Quantidade de aluno',
       ees_des_estrutura_escola AS 'Estrutura da escola',
       CASE pee_possui_acessibilidade
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Possui acessibilidade?',
       CASE pee_abre_final_semana
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Abre finais de semana?',
       CASE oge_avaliacao_interna
           WHEN 0 THEN 'Sim'
           WHEN 1 THEN 'Não'
       END AS 'Existe algum instrumento de avaliação da sua gestão?',
       oge_importancia_diretor AS '0 a 10, importancia do gestor para aprendizagem dos alunos'
  FROM db_gpge.pge_pesquisa_gestao INNER JOIN db_gpge.des_dados_escola
  ON des_id_escola = pge_id_escola LEFT JOIN db_gpge.fge_formacao_gestor
  ON fge_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.nfo_nivel_formacao
  ON nfo_id_nivel_formacao = fge_id_nivel_formacao LEFT JOIN db_gpge.peg_perfil_gestor
  ON peg_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.fet_faixa_etaria
  ON fet_id_faixa_etaria = peg_id_faixa_etaria LEFT JOIN db_gpge.res_rede_escola
  ON res_id_rede_escola = peg_id_rede_escola_antes LEFT JOIN  db_gpge.sog_sobre_gestao
  ON sog_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.oca_obtencao_cargo
  ON oca_id_obtencao_cargo = sog_id_obtencao_cargo LEFT JOIN db_gpge.cge_curso_gestao
  ON cge_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.ccu_colaboracao_curso
  ON ccu_id_colaboracao_curso = cge_id_colaboracao_curso LEFT JOIN db_gpge.pfo_preparacao_formacao
  ON pfo_id_prepacao_formacao = sog_id_preparacao_formacao LEFT JOIN db_gpge.pee_perfil_escola
  ON pee_id_pesquisa_gestao = pge_id_pesquisa_gestao LEFT JOIN db_gpge.ees_estrutura_escola
  ON ees_id_estrutura_escola = pee_id_estrutura_escola LEFT JOIN db_gpge.oge_organizacao_gestao_escola
  ON oge_id_pesquisa_gestao = pge_id_pesquisa_gestao
WHERE pge_data_ultima_alteracao IS NOT NULL
GROUP BY pge_id_pesquisa_gestao, des_nome_escola, peg_genero, fet_des_faixa_etaria,
         peg_exerceu_gestao_antes, res_des_rede_escola, peg_gestor_qnts_vezes, peg_ch_semanal_gestao,
         oca_des_obtencao_cargo, sog_participou_curso, cge_quantidade_curso, cge_quando_ultimo,
         ccu_des_colaboracao_curso, pfo_des_preparacao_formacao, pee_turno_escolar_M, pee_turno_escolar_V,
         pee_turno_escolar_N, pee_qnt_alunos, ees_des_estrutura_escola, pee_possui_acessibilidade,
         pee_abre_final_semana, oge_avaliacao_interna, oge_importancia_diretor;

############################################ INSERT's ############################################

-- NIVEL FORMAÇÃO
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (0, 'Licenciatura');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (1, 'Bacharelado');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (2, 'Especialização');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (3, 'Mestrado');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (4, 'Mestrando');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (5, 'Doutor');
# INSERT INTO db_gpge.nfo_nivel_formacao (nfo_id_nivel_formacao, nfo_des_nivel_formacao) VALUES (6, 'Doutorando');

-- FAIXA ETARIA
# INSERT INTO db_gpge.fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (0, 'Até 30 anos');
# INSERT INTO db_gpge.fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (1, '31 a 40 anos');
# INSERT INTO db_gpge.fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (2, '41 a 50 anos');
# INSERT INTO db_gpge.fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (3, '51 a 60 anos');
# INSERT INTO db_gpge.fet_faixa_etaria (fet_id_faixa_etaria, fet_des_faixa_etaria) VALUES (4, 'Mais de 60 anos');

-- REDE ESCOLA
# INSERT INTO db_gpge.res_rede_escola (res_id_rede_escola, res_des_rede_escola) VALUES ('M', 'Municipal');
# INSERT INTO db_gpge.res_rede_escola (res_id_rede_escola, res_des_rede_escola) VALUES ('E', 'Estadual');
# INSERT INTO db_gpge.res_rede_escola (res_id_rede_escola, res_des_rede_escola) VALUES ('A', 'Municipal e Estadual');

-- OBTENCAO DE CARGO
# INSERT INTO db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (0, 'Concurso público');
# INSERT INTO db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (1, 'Eleição direta');
# INSERT INTO db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (2, 'Seleção técnica');
# INSERT INTO db_gpge.oca_obtencao_cargo (oca_id_obtencao_cargo, oca_des_obtencao_cargo) VALUES (3, 'Indicação política');

-- COLABORAÇÃO DO CURSO
# INSERT INTO db_gpge.ccu_colaboracao_curso (ccu_id_colaboracao_curso, ccu_des_colaboracao_curso) VALUES ('N', 'Não colaboraram');
# INSERT INTO db_gpge.ccu_colaboracao_curso (ccu_id_colaboracao_curso, ccu_des_colaboracao_curso) VALUES ('C', 'Colaboraram');
# INSERT INTO db_gpge.ccu_colaboracao_curso (ccu_id_colaboracao_curso, ccu_des_colaboracao_curso) VALUES ('P', 'Colaboraram pouco');
# INSERT INTO db_gpge.ccu_colaboracao_curso (ccu_id_colaboracao_curso, ccu_des_colaboracao_curso) VALUES ('M', 'Colaboraram muito');

-- TEMAS
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (0, 'Liderança');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (1, 'Projeto político pedagógico');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (2, 'Políticas públicas');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (3, 'Organizações da aprendizagem');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (4, 'Tecnologias e aprendizagem');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (5, 'Financiamento');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (6, 'Finanças');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (7, 'Trabalho em equipe');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (8, 'Noções de administração e legislação');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (9, 'Cidadania e sustentabilidade');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (10, 'Gestão participativa e democrática');
# INSERT INTO db_gpge.tem_tema (tem_id_tema, tem_des_tema) VALUES (11, 'Prestação de contas');

-- PREPARAÇÃO DA FORMAÇÃO
# INSERT INTO db_gpge.pfo_preparacao_formacao (pfo_id_prepacao_formacao, pfo_des_preparacao_formacao) VALUES (0, 'Não preparou');
# INSERT INTO db_gpge.pfo_preparacao_formacao (pfo_id_prepacao_formacao, pfo_des_preparacao_formacao) VALUES (1, 'Preparou pouco');
# INSERT INTO db_gpge.pfo_preparacao_formacao (pfo_id_prepacao_formacao, pfo_des_preparacao_formacao) VALUES (2, 'Preparou');
# INSERT INTO db_gpge.pfo_preparacao_formacao (pfo_id_prepacao_formacao, pfo_des_preparacao_formacao) VALUES (3, 'Preparou muito');

-- CURSO
# INSERT INTO db_gpge.cur_curso (cur_id_curso, cur_des_curso) VALUES (0, 'Ensino médio');
# INSERT INTO db_gpge.cur_curso (cur_id_curso, cur_des_curso) VALUES (1, 'Curso profissionalizante');

-- ESTRUTURA ESCOLA
# INSERT INTO db_gpge.ees_estrutura_escola (ees_id_estrutura_escola, ees_des_estrutura_escola) VALUES ('P', 'Péssima estrutura física');
# INSERT INTO db_gpge.ees_estrutura_escola (ees_id_estrutura_escola, ees_des_estrutura_escola) VALUES ('R', 'Razoável estrutura física');
# INSERT INTO db_gpge.ees_estrutura_escola (ees_id_estrutura_escola, ees_des_estrutura_escola) VALUES ('B', 'Boa estrutura física');
# INSERT INTO db_gpge.ees_estrutura_escola (ees_id_estrutura_escola, ees_des_estrutura_escola) VALUES ('O', 'Ótima estrutura física');

-- SATISFAÇÃO
# INSERT INTO db_gpge.sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES ('MI', 'Muito insatisfeito');
# INSERT INTO db_gpge.sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES ('I', 'Insatisfeito');
# INSERT INTO db_gpge.sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES ('N', 'Neutro');
# INSERT INTO db_gpge.sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES ('S', 'Satisfeito');
# INSERT INTO db_gpge.sat_satisfacao (sat_id_satisfacao, sat_des_satisfacao) VALUES ('MS', 'Muito satisfeito');

-- CONSELHO
# INSERT INTO db_gpge.con_conselho (con_id_conselho, con_des_conselho) VALUES (0, 'Colegiado escolar');
# INSERT INTO db_gpge.con_conselho (con_id_conselho, con_des_conselho) VALUES (1, 'Associação de pais e mestres');

-- AGENTES
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (0, 'Aluno');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (1, 'Família');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (2, 'Direção escolar');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (3, 'Professor');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (4, 'Coordenador pedagógico');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (5, 'Governo');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (6, 'Projeto pedagógico da escola');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (7, 'Merenda escolar');
# INSERT INTO db_gpge.age_agente (age_id_agente, age_des_agente) VALUES (8, 'Bolsa família');