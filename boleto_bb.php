<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa				        |
// | 														                                   			  |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +--------------------------------------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>              		             				|
// | Desenvolvimento Boleto Banco do Brasil: Daniel William Schultz / Leandro Maniezo / Rogério Dias Pereira|
// +--------------------------------------------------------------------------------------------------------+

date_default_timezone_set('America/Recife');

// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$data_venc = $_GET['data_vencimento'];  // Prazo de X dias OU informe data: "13/04/2006";
$valor_cobrado = $_GET['valor'];
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado, 2, ',', '');

$dadosboleto["nosso_numero"] = $_GET['borderaux'];
$dadosboleto["numero_documento"] = $_GET['borderaux'];	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = $_GET['data_documento']; // Data de emissão do Boleto
$dadosboleto["data_processamento"] = $_GET['data_processamento']; // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $_GET['sacado'];
$dadosboleto["endereco1"] = $_GET['endereco1'];
$dadosboleto["endereco2"] = $_GET['endereco2'];

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = isset($_GET['demonstrativo1']) ? $_GET['demonstrativo1'] : '';
$dadosboleto["demonstrativo2"] = isset($_GET['demonstrativo2']) ? $_GET['demonstrativo2'] : '';
$dadosboleto["demonstrativo3"] = isset($_GET['demonstrativo3']) ? $_GET['demonstrativo3'] : '';

// INSTRUÇÕES PARA O CAIXA
$dadosboleto["instrucoes1"] = isset($_GET['instrucoes1']) ? $_GET['instrucoes1'] : '';
$dadosboleto["instrucoes2"] = isset($_GET['instrucoes2']) ? $_GET['instrucoes2'] : '';
$dadosboleto["instrucoes3"] = isset($_GET['instrucoes3']) ? $_GET['instrucoes3'] : '';
$dadosboleto["instrucoes4"] = isset($_GET['instrucoes4']) ? $_GET['instrucoes4'] : '';

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = isset($_GET['quantidade']) ? $_GET['quantidade'] : '';
$dadosboleto["valor_unitario"] = isset($_GET['valor_unitario']) ? $_GET['valor_unitario'] : '';
$dadosboleto["aceite"] = isset($_GET['aceite']) ? $_GET['aceite'] : 'N';
$dadosboleto["especie"] = isset($_GET['especie']) ? $_GET['especie'] : 'R$';
$dadosboleto["especie_doc"] = isset($_GET['especie_doc']) ? $_GET['especie_doc'] : 'DM';


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANCO DO BRASIL
$dadosboleto["agencia"] = $_GET['agencia']; // Num da agencia, sem digito
$dadosboleto["conta"] = $_GET['conta']; 	// Num da conta, sem digito

// DADOS PERSONALIZADOS - BANCO DO BRASIL
$dadosboleto["convenio"] = $_GET['convenio'];  // Num do convênio - REGRA: 6 ou 7 ou 8 dígitos
$dadosboleto["contrato"] = "999999"; // Num do seu contrato
$dadosboleto["carteira"] = $_GET['carteira'];
$dadosboleto["variacao_carteira"] = $_GET['variacao_carteira'];  // Variação da Carteira, com traço (opcional)

// TIPO DO BOLETO
$dadosboleto["formatacao_convenio"] = "7"; // REGRA: 8 p/ Convênio c/ 8 dígitos, 7 p/ Convênio c/ 7 dígitos, ou 6 se Convênio c/ 6 dígitos
$dadosboleto["formatacao_nosso_numero"] = "2"; // REGRA: Usado apenas p/ Convênio c/ 6 dígitos: informe 1 se for NossoNúmero de até 5 dígitos ou 2 para opção de até 17 dígitos

/*
#################################################
DESENVOLVIDO PARA CARTEIRA 18

- Carteira 18 com Convenio de 8 digitos
  Nosso número: pode ser até 9 dígitos

- Carteira 18 com Convenio de 7 digitos
  Nosso número: pode ser até 10 dígitos

- Carteira 18 com Convenio de 6 digitos
  Nosso número:
  de 1 a 99999 para opção de até 5 dígitos
  de 1 a 99999999999999999 para opção de até 17 dígitos

#################################################
*/


// SEUS DADOS
$dadosboleto["identificacao"] = "Boleto para pagamento";
$dadosboleto["cpf_cnpj"] = $_GET['cpf_cnpj_empresa'];
$dadosboleto["cedente"] = $_GET['cedente'];

// NÃO ALTERAR!
include("include/funcoes_bb.php");
include("include/layout_bb.php");
?>
