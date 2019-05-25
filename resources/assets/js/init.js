$(function () {
  $('[name = rNivelFormacao]').click(function () {
    var val = $(this).val();
    $(".mestrado, .doutor, .mestrando, .doutorando").hide();
    $("." + val).show();
  });

  $("[name = rGestorAntes]").click(function() {
    var val = $(this).val();
    if (val == "1") $(".rGestorAntes").show("slow");
    else $(".rGestorAntes").hide("slow");
  });

  $("[name = rObteveCargo]").click(function() {
    var val = $(this).val();
    if (val == "O") $(".rObteveCargo").show();
    else $(".rObteveCargo").hide();
  });

  $("[name = rCursoGestao]").click(function() {
    var val = $(this).val();
    if (val == "1") $(".rCursoGestao").show("slow");
    else $(".rCursoGestao").hide("slow");
  });
  
  $("[name = rAcessibilidade]").click(function() {
    var val = $(this).val();
    if (val == "1") $(".rAcessibilidade").show("slow");
    else $(".rAcessibilidade").hide("slow");
  });

  $("[name = rAvaliacaoInterna]").click(function() {
    var val = $(this).val();
    if (val == "1") $(".rAvaliacaoInterna").show("slow");
    else $(".rAvaliacaoInterna").hide("slow");
  });

  $("[name = rAbreFinalSemana]").click(function() {
    var val = $(this).val();
    if (val == "1") $(".rAbreFinalSemana").show("slow");
    else $(".rAbreFinalSemana").hide("slow");
  });

  var nvlFormacao = $("input[name='rNivelFormacao']:checked").val();
  if (nvlFormacao) $("." + nvlFormacao).show();
  if ($("input[name='rGestorAntes']:checked").val() == "1") $(".rGestorAntes").show();
  if ($("input[name='rObteveCargo']:checked").val() == 'O') $(".rObteveCargo").show();
  if ($("input[name='rCursoGestao']:checked").val() == '1') $(".rCursoGestao").show();
  if ($("input[name='rAcessibilidade']:checked").val() == "1") $(".rAcessibilidade").show();
  if ($("input[name='rAbreFinalSemana']:checked").val() == "1") $(".rAbreFinalSemana").show();
  if ($("input[name='rAvaliacaoInterna']:checked").val() == "1") $(".rAvaliacaoInterna").show();

  // Desocultando objetos com checked auto php
  $("input[name='cTemaFormacao[]']:checked").each(function () {
    if ($(this).val() == "O")
    {
      $('#ctfdOutro').prop('disabled', false);
      $(".cTemaFormacao").show();
      $("#ttfdOutro").val($("#ttfOutro").val());
    }
    $('[name="cTemaFormacaoDesenvolvimento[]"][value="' + $(this).val() + '"]').closest('label.oculto').show();
  });


  $("input[name='cCursoEscola[]']:checked").each(function () {
    if ($(this).val() == "O") $(".cCursoEscola").show();
  });

  $("input[name='cConselhosExistentes[]']:checked").each(function() {
    if ($(this).val() == "O") $(".cConselhosExistentes").show();
  });

  $("input[name='cBaixoRendimento[]']:checked").each(function () {
    if ($(this).val() == "O") $(".cBaixoRendimento").show();
  });
  //

  $("input, textarea").on("change", function() {
    $("#flag").val('1');
  });

  // Utilização da função limite()
  // document.getElementById('nNotaIdeb2015').onkeypress = limite;
  // document.getElementById('nNotaIdeb2016').onkeypress = limite;

})

function checkOculto(check, obj)
{
  if ($(check).is(":checked")) $("." + obj).show();
  else $("." + obj).hide();
}

function checkOcultoText(check, checkText, obj)
{
  if ($(check).is(":checked")) $("." + obj).show();
  else
  {
    $("." + obj).hide();
    $("#" + checkText).val("").change();
  }
}

function checkTema(check, campoOculto, taCampoOculto)
{
  var val = $(check).val();
  var v;
  
  if ($(check).is(":checked"))
  {
    $('[name="'+campoOculto+'"][value="'+val+'"]').closest('label.oculto').show();
  }
  else
  {
    var imp = $("#" + taCampoOculto).val();
    var vals = [];
    if (imp) vals = imp.split("; ");
    if ((v = vals.indexOf(val)) != -1) vals.splice(v, 1);
    vals = vals.join("; ");
    $("#" + taCampoOculto).val(vals);
    
    $('[name="'+campoOculto+'"][value="'+val+'"]').prop('checked', false);
    $('[name="'+campoOculto+'"][value="'+val+'"]').closest('label.oculto').hide();
  }
}

function checkImportancia(check, textArea)
{
  var imp = $("#" + textArea).val();
  var vals = [];

  if (imp) vals = imp.split("; ");

  if ($(check).is(":checked")) vals.push($(check).val());
  else vals.splice(vals.indexOf($(check).val()), 1);

  vals = vals.join("; ");
  $("#" + textArea).val(vals);
}

function checkImportanciaAlt(check, input, textArea)
{
  var imp = $("#" + textArea).val();
  var vals = [];

  if (imp) vals = imp.split("; ");

  if ($(check).is(":checked")) vals.push($('#' + input).val());
  else vals.splice(vals.indexOf($('#' + input).val()), 1);

  vals = vals.join("; ");
  $("#" + textArea).val(vals);
}

function checkImportanciaOutro(input, inputAnterior, textArea) {
  var imp = $("#" + textArea).val();
  var vals = [];
  var val = $(input).val();
  var valAnterior = $("#" + inputAnterior).val();

  if (imp) vals = imp.split("; ");

  // verifica se o campo está preenchido
  if (val)
  {
    // verifica se existi valor anterior e altera/preenche
    if (valAnterior)
      vals[vals.indexOf(valAnterior)] = val;
    else
      vals.push(val);
  }
  else
    // Apaga a ocorrencia da lista caso seja ocultado
    if (valAnterior)
      vals.splice(vals.indexOf(valAnterior), 1);

  $("#" + inputAnterior).val(val);

  vals = vals.join("; ");
  $("#" + textArea).val(vals);
}

function checkTemaOutro(input, input_2, checkOutro, textArea) {
  var imp = $("#" + textArea).val();
  var vals = [];

  var val = $(input).val();
  var val_2 = $('#' + input_2).val();

  if (imp) vals = imp.split("; ");
  
  // verifica se o campo está preenchido
  if (val)
  {
    $('#' + checkOutro).prop('disabled', false);
    // verifica se existi valor anterior e altera/preenche
    if (val != val_2)
    {
      if (vals.indexOf(val_2) != -1)
        vals[vals.indexOf(val_2)] = val;
      $('#' + input_2).val(val);
    }
  }
  else
  {
    if (vals.indexOf(val_2) != -1)
      vals.splice(vals.indexOf(val_2), 1);
    $("#" + input_2).val("");
    $("#" + checkOutro).prop("disabled", true);
    $('#' + checkOutro).prop('checked', false);
  }

  vals = vals.join("; ");
  $("#" + textArea).val(vals);
}

function noSubmitEnter()
{
  // Evitando submit com enter
  $(window).keydown(function (event) {
    if (event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
}

// Limitando input number em tempo real
// function limite(e) {
//   try {
//     var element = e.target
//   } catch (er) { };
//   try {
//     var element = event.srcElement
//   } catch (er) { };
//   try {
//     var ev = e.which
//   } catch (er) { };
//   try {
//     var ev = event.keyCode
//   } catch (er) { };
//   if ((ev != 0) && (ev != 8) && (ev != 13))
//     if (!RegExp(/[0-9]/gi).test(String.fromCharCode(ev)))
//       return false;

//   if (element.value + String.fromCharCode(ev) > 10) return false;
// }