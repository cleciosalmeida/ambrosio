// Função para atualizar o texto explicativo
function atualizarTextoExplicativo() {
    // Obter o valor do tipo de abelha selecionado
    let tipoCaixa = document.getElementById("calc_abelhas").value;
  
    // Definir o texto explicativo para cada tipo de caixa
    let textoExplicativo = '';
    switch (tipoCaixa) {
      case 'Mandaçaia':
        textoExplicativo = 'A caixa para abelhas Mandaçaia deve ser maior, com medidas que permitem boa ventilação e espaço interno, devido ao tamanho dessas abelhas.';
        break;
      case 'Jataí':
        textoExplicativo = 'A caixa para abelhas Jataí costuma ser menor, pois essas abelhas são de menor porte e se adaptam a espaços mais compactos.';
        break;
      case 'Canudo':
        textoExplicativo = 'As abelhas Canudo precisam de uma caixa de tamanho moderado, com entradas tubulares que imitam seus ninhos naturais.';
        break;
      case 'Mirim':
        textoExplicativo = 'Para as abelhas Mirim, recomenda-se uma caixa pequena e bem ventilada, já que são abelhas pequenas que não exigem muito espaço.';
        break;
      case 'Manduri':
        textoExplicativo = 'As abelhas Manduri exigem caixas com bom isolamento térmico, pois elas são sensíveis a variações de temperatura.';
        break;
    }
  
    // Atualizar o conteúdo da label de texto explicativo
    document.getElementById("texto_explicativo").innerText = textoExplicativo;
  }
  
  // Função de cálculo de madeira
  function calcular() {
    // Impede o envio do formulário (evitando o reload da página)
    event.preventDefault();
    
    // Obter o valor do tipo de abelha selecionado
    let tipoCaixa = document.getElementById("calc_abelhas").value;
    
    // Obter as medidas inseridas
    let modulo = parseFloat(document.getElementById("modulo_01").value);
    let custo = parseFloat(document.getElementById("custo_01").value);
    
    // Verificar se os campos de altura e largura foram preenchidos
    if (isNaN(modulo) || isNaN(custo)) {
      document.getElementById("resultado").innerText = "Por favor, insira valores válidos para altura e largura.";
      return;
    }
  
    // Definir um fator para o cálculo com base no tipo de abelha
    let fator = 1; // Valor padrão
    switch (tipoCaixa) {
      case 'Mandaçaia':
        fator = 1.2;
        break;
      case 'Jataí':
        fator = 0.8;
        break;
      case 'Canudo':
        fator = 1.0;
        break;
      case 'Mirim':
        fator = 0.7;
        break;
      case 'Manduri':
        fator = 0.9;
        break;
    }
  
    // Cálculo da quantidade de madeira (simples multiplicação com fator)
    let quantidadeMadeira = modulo * custo * fator;
  
    // Exibir o resultado na label
    document.getElementById("resultado").innerText = 
      `Quantidade de madeira necessária para a caixa de ${tipoCaixa}: ${quantidadeMadeira.toFixed(2)} unidades`;
  }
  
