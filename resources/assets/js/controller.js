function selectPesquisa() {
  $.ajax ({
    url: "php/controller_adm/select_pesquisa.php",
    type: "POST",
    data: {
      periodo: $('#periodoPesquisa').val()
    },
    // beforeSend: function() {
    //   $("#alert-cadastro").html(
    //     '<div class="preloader-wrapper big active center-block">' +
    //       '<div class="spinner-layer spinner-green-only">' +
    //       '<div class="circle-clipper left">' +
    //       '<div class="circle"></div>' +
    //       "</div>" +
    //       '<div class="gap-patch">' +
    //       '<div class="circle"></div>' +
    //       "</div>" +
    //       '<div class="circle-clipper right">' +
    //       '<div class="circle"></div>' +
    //       "</div>" +
    //       "</div>" +
    //       "</div>"
    //   );
    //   $(".conteudoCadastro").hide();
    // },
    success: function(data) {
      var dados = $.parseJSON(data);
      var tam = dados.length;
      var qt_sub = 0;
      var qt_edicao = 0;
      var comp;

      //$("#alert-cadastro").html("");
      if (tam) {$("#tabelaPesquisa").show();$("#buttonMensagem").show();}
      else {$("#tabelaPesquisa").hide();$("#buttonMensagem").hide()}
      $('#bodyTabelaPesquisa').html("");
      for (var i = 0; i < tam; i ++) {
        if (dados[i].situacao == 1) {
          comp = "<span class='glyphicon glyphicon-ok' aria-hidden='true'></span>";
          qt_sub ++;
        } else {
          if ((dados[i].situacao == 0) && dados[i].ultima_alteracao) {
            comp = "<span class='glyphicon glyphicon-time' aria-hidden='true'></span>";
            qt_edicao ++;
          } else
            comp = "-";
        }
        $('#bodyTabelaPesquisa').append(
          "<tr style='cursor: hand' <!--onclick=\"mostrarConteudo('view/relatorioBolsa.php?numPro=$codigo', 'conteudo')\"-->>"
          +"<td><strong>" + (i + 1) + "</strong></td>"
          +"<td>" + dados[i].nome_escola + "</td>"
          +"<td>" + dados[i].municipio + "</td>"
          +"<td><button onclick='altDest(\"" + dados[i].email + "\")' type='button' class='btn btn-link' data-toggle='modal' data-target='#enviarMensagem'>" + dados[i].email + "</button></td>"
          +"<td>" + (dados[i].ultima_alteracao != null 
            ? dados[i].ultima_alteracao
            : "-")
          + "</td><td>" + comp + "</td>"
          + "<td><a href='adm/pesquisa_gestao/dados_gerais.php?id=" + dados[i].id_pesquisa_gestao + "' target='_blank'><span class='glyphicon glyphicon-open-file aria-hidden='true'></span></a></td>"
          +"<td>" + dados[i].codigo_acesso + "</td></tr>"
        );
      }
      $('#relatorio').html("<span class='text-success'>Submetidos: <b>" + qt_sub
      + "</b></span> <span class='text-warning'>Em edição: <b>" + qt_edicao
      + "</b></span> <span class='text-danger'>Pendentes: <b>" + (tam - qt_edicao - qt_sub) + "</span> [" + tam + "]</b>");
    
      $('#destClick').html('Selecione uma opção');
      $('#destClick').attr('selected', true);
    }
  });
}

function selectEvento() {
  $.ajax ({
    url: "php/controller_adm/select_evento.php",
    type: "POST",
    data: {
      evento: $('#evento').val()
    },
    success: function(data) {
      var dados = $.parseJSON(data);
      var tam = dados.length;
      var dt;

      if (tam) $("#tabelaEvento").show()
      else $("#tabelaEvento").hide();
      $('#bodyTabelaEvento').html("");
      for (var i = 0; i < tam; i ++) {
        dt = new Date(dados[i].data_inscricao);
        $('#bodyTabelaEvento').append(
          "<tr style='cursor: hand' <!--onclick=\"mostrarConteudo('view/relatorioBolsa.php?numPro=$codigo', 'conteudo')\"-->>"
          +"<td><strong>" + (i + 1) + "</strong></td>"
          +"<td>" + dados[i].nome + " " + dados[i].sobrenome + "</td>"
          +"<td>" + dados[i].apelido + "</td>"
          +"<td>" + dados[i].escola + "</td>"
          +"<td>" + dados[i].municipio + "</td>"
          +"<td>" + (dados[i].respondeu_pesquisa == 1 ? "Sim" : "Não") + "</td>"
          +"<td>" + dt.toLocaleDateString('pt-BR') + ' '
            + dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds() + "</td>"
          + "<td><a onclick='exibiFichaInscrito(" + dados[i].id_inscrito + ")'><span class='glyphicon glyphicon-open-file aria-hidden='true'></span></a></td></tr>"
        );
      }
      $('#relatorio').html("<span class='text-success'>Inscritos: <b>" + tam + "</span></b>");
    }
  });
}

function validarPesquisa() {

  var start = $("#dPeriodoInicial").val();
  var end = $("#dPeriodoFinal").val();
  var data = new Date();

  var dia = data.getDate();
  if (dia < 10) {
    dia = "0" + dia;
  }

  var mes = data.getMonth() + 1;
  if (mes < 10) {
    mes = "0" + mes;
  }

  var ano = data.getFullYear();
  hoje = ano + "-" + mes + "-" + dia;

  if (end < start || end < hoje) {
    $("#alert").show();
    $("#alert").html("Favor inserir um período válido. O período final não pode ser menor que hoje ou o incial");
    return false;
  } else {
    $.ajax({
      url: "php/controller_adm/validar_pesquisa.php",
      type: "POST",
      data: {
        fim: end
      },
      beforeSend: function() {
        $("#alert").show();
        $("#alert").html("Gerando pesquisa. Aguarde...");
      },
      success: function (data) {
        var dado = $.parseJSON(data);
        
        if (dado[0]) {
          $("#alert").show();
          $("#alert").html("Já existe uma pesquisa em andamento, favor aguardar finalizar em [" + dado[1] + "]");
          return false;
        } else {
          $(".conteudoForm").hide();
          $("#formGerador").submit();
        }
      }
    });
  }
}

function exibiFichaInscrito(id) {
  $.ajax({
    url: "php/controller_adm/select_ficha_inscrito.php",
    type: "POST",
    data: {
      id_inscrito: id
    },
    beforeSend: function() {
      $("#mNome_completo").html("");
      $("#mNome_cracha").html("");
      $("#mFormacao").html("");
      $("#mEscola").html("");
      $("#mRespondeu_pesquisa").html("");
      $("#mTemas").html("");
      $("#mTelefone").html("");
      $("#mEmail").html("");
    },
    success: function (data) {
      var dado = $.parseJSON(data);
      $("#mNome_completo").html(dado.nome);
      $("#mNome_cracha").html(dado.apelido);
      $("#mFormacao").html(dado.formacao);
      $("#mEscola").html(dado.escola);
      $("#mRespondeu_pesquisa").html(dado.respondeu_pesquisa);
      $("#mTemas").html((dado.temas ? dado.temas : "Não informado"));
      $("#mTelefone").html(dado.telefone);
      $("#mEmail").html(dado.email);

      $("#modalInscrito").modal('show');
    }
  });
}

function enviarMensagem() {

  var id_pesquisa = $("#periodoPesquisa").val();
  var tipo_dest = $("#sDestinatario").val();
  var assunto = $("#tAssunto").val();
  var mensagem = $("#taMensagem").val();
  var id_usuario = $("#hIdUsuario").val();
  var lembrete = 0;
  var email_dest;
  
  if ($("#cLembrete").is(":checked")) lembrete = 1;
  if (tipo_dest == 4) email_dest = $("#destClick").text();

  $("#alertMensagem").hide();
  $("#alertMensagem").html("");

  if (!mensagem || !assunto) {
    $("#alertMensagem").show();
    $("#alertMensagem").html("Campo de mensagem e assunto são obrigatórios");
  } else {
    $.ajax({
      url: "php/controller_adm/enviar_mensagem.php",
      type: "POST",
      data: {
        pesq: id_pesquisa,
        usr: id_usuario,
        tdest: tipo_dest,
        ass: assunto,
        msg: mensagem,
        lbt: lembrete,
        edest: email_dest
      },
      beforeSend: function() {
        $(".conteudoFormMensagem").hide();
        $("#alertMensagem").show();
        $("#alertMensagem").html("Enviando mensagem. Aguarde...");
      }
    })
    .done(function (data) {
      var dado = $.parseJSON(data);

      $(".conteudoFormMensagem").show();
      $("#alertMensagem").hide();
      $("#alertMensagem").html("");
      
      if (dado.enviado) {
        alert("Enviado com sucesso");
        // Retornando aos ajustes padrões
        $("#sDestinatario").find('[value="0"]').prop('selected', true);
        $("#tAssunto").val("");
        $("#taMensagem").val("");
        $("#cLembrete").prop("checked", false);
      }
      else
        alert("Erro no envio da mensagem");

    });
  }
}

function tabelaLog (codTabela) {
  $("#tabelaLogAcesso").hide();
  $("#tabelaLogMensagem").hide();

  switch (codTabela) {
    case 0:
      $("#tabelaLogAcesso").show();
      break;
    case 1:
      $("#tabelaLogMensagem").show();
      break;
    default:
  }
}

function altDest(email) {
  $('#destClick').html(email);
  $('#destClick').attr('selected', true);
}

// function lembretePesquisa() {

//   $.ajax({
//     url: "php/controller_adm/lembrete_pesquisa.php",
//     type: "POST",
//     data: {
//       idPesquisa: $("#periodoPesquisa").val()
//     },
//     success: function (data) {
//       var dado = $.parseJSON(data);
      
//       if (dado[0]) {
//         $("#buttonMensagem").hide();
//         alert("Lembrete enviado com sucesso");
//       } else {
//         alert("Erro ao gerar lembrete");
//       }
//     }
//   });
// }