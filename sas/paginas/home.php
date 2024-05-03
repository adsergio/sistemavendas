<?php

//Tolizar as empresas
$query = $pdo->query("SELECT * FROM empresas WHERE ativo = 'Sim' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_empresas = count($res);


//Totaliar contas a receber hoje
$total_receber_hoje = 0;
$query = $pdo->query("SELECT * FROM receber WHERE data_venc = curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($res); $i++) {
$total_receber_hoje += $res[$i]['valor'];
}
$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');


//Totaliar contas a pagar hoje
$total_pagar_hoje = 0;
$query = $pdo->query("SELECT * FROM pagar WHERE data_venc = curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($res); $i++) {
	$total_pagar_hoje += $res[$i]['valor'];
	}
$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');

	
	

// Saldo do Mês
$total_receber_mes = 0;
$query = $pdo->query("SELECT * FROM receber WHERE data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and tipo = 'Empresa' and empresa = '0' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($res); $i++) {
$total_receber_mes += $res[$i]['valor'];
}


//Totaliar contas a pagar Mês
$total_pagar_mes = 0;
$query = $pdo->query("SELECT * FROM pagar WHERE data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and tipo = 'Empresa' and empresa = '0' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($res); $i++) {
	$total_pagar_mes += $res[$i]['valor'];
}


$total_saldo_mes = $total_receber_mes - $total_pagar_mes;
$total_saldo_mesF = number_format($total_saldo_mes, 2, ',', '.');


if($total_saldo_mes < 0){
	$classe_saldo = 'user1';
}else{
	$classe_saldo = 'dollar2';
}

//Recebimentos vencidos
$total_receber_vencidos = 0;
$query = $pdo->query("SELECT * FROM receber WHERE data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i = 0; $i < @count($res); $i++) {
$total_receber_vencidos += $res[$i]['valor'];
}
$total_receber_vencidosF = number_format($total_receber_vencidos, 2, ',', '.');

//Totalizar dados do Gráfico

$dados_meses_despesas =  '';
$dados_meses_receitas =  '';
        //ALIMENTAR DADOS PARA O GRÁFICO
        for($i=1; $i <= 12; $i++){

            if($i < 10){
                $mes_atual = '0'.$i;
            }else{
                $mes_atual = $i;
            }

        if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
            $dia_final_mes = '30';
        }else if($mes_atual == '2'){
            $dia_final_mes = '28';
        }else{
            $dia_final_mes = '31';
        }


        $data_mes_inicio_grafico = $ano_atual."-".$mes_atual."-01";
        $data_mes_final_grafico = $ano_atual."-".$mes_atual."-".$dia_final_mes;

		  //DESPESAS
		  $total_mes_despesa = 0;
		  $query = $pdo->query("SELECT * FROM pagar where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' AND tipo = 'Empresa' AND empresa = '0' ORDER BY id asc");
		  $res = $query->fetchAll(PDO::FETCH_ASSOC);
		  $total_reg = @count($res);
		  if($total_reg > 0){
			  for($i2=0; $i2 < $total_reg; $i2++){
				  foreach ($res[$i2] as $key => $value){}
			  $total_mes_despesa +=  $res[$i2]['valor'];
		  }
		  }
  
		  $dados_meses_despesas = $dados_meses_despesas. $total_mes_despesa. '-';
  
  
  
  
  
		   //RECEITAS
		  $total_mes_receita = 0;
		  $query = $pdo->query("SELECT * FROM receber where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico'AND tipo = 'Empresa' AND empresa = '0' ORDER BY id asc");
		  $res = $query->fetchAll(PDO::FETCH_ASSOC);
		  $total_reg = @count($res);
		  if($total_reg > 0){
			  for($i2=0; $i2 < $total_reg; $i2++){
				  foreach ($res[$i2] as $key => $value){}
			  $total_mes_receita +=  $res[$i2]['valor'];
		  }
		  }
  
		  $dados_meses_receitas = $dados_meses_receitas. $total_mes_receita. '-'; 
  
	} 

?>



<div class="main-page">

<input type="text" name="id" id="dados_grafico_despesa">
<input type="text" name="id" id="dados_grafico_receita">

	<div class="col_3">
		<a href="index.php?pagina=empresas">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_empresas ?></big></strong></h5>
				</div>
				<hr style="margin-top:10px">
				<span style="color:#6d6d6e" !importamt>Clientes Ativos</span>
			</div>
			</a>
			
		</div>
		<div class="col-md-3 widget widget1">
		<a href="index.php?pagina=receber">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-usd dollar2 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big>R$ <?php echo @$total_receber_hojeF ?></big></strong></h5>
				</div>
				<hr style="margin-top:10px">
				<span style="color:#6d6d6e" !importamt>Recebimentos Hoje</span>
			</div>
			</div>
		</div>

		<div class="col_3">
		<a href="index.php?pagina=pagar">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money user1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big>R$ <?php echo @$total_pagar_hojeF ?></big></strong></h5>
				</div>
				<hr style="margin-top:10px">
				<span style="color:#6d6d6e" !importamt>Pagamentos Hoje</span>
			</div>
			</a>
			
		</div>
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
			<i class="pull-left fa fa-money dollar1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big>R$ <?php echo @$total_receber_vencidosF ?></big></strong></h5>
				</div>
				<hr style="margin-top:10px">
				<span style="color:#6d6d6e" !importamt>Recebimentos vencidos</span>
			</div>
			</div>
		</div>
		<div class="col-md-3 widget">
			<div class="r3_counter_box">
			<i class="pull-left fa fa-usd <?php echo $classe_saldo?> icon-rounded"></i>
				<div class="stats">
					<h5><strong><big>R$ <?php echo @$total_saldo_mesF ?></big></strong></h5>
				</div>
				<hr style="margin-top:10px">
				<span style="color:#6d6d6e" !importamt>Saldo Mês</span>
			
			</div>
		</div>
		<div class="clearfix"> </div>
	</div>
	
	<div class="row-one widgettable">
		<div class="col-md-12 content-top-2 card">
			<div class="agileinfo-cdr">
				<div class="card-header">
					<h3>Weekly Sales</h3>
				</div>
				
				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>
				
			</div>
		</div>
		
		<div class="clearfix"> </div>
	</div>
	
	
	

	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>
	var graphdata1 = {
		linecolor: "#f2371f",
		title: "Despesas",
		values: [
		{ X: "Janeiro", Y: parseFloat(saldo_mes[1])},
		{ X: "Fevereiro", Y: 20.00 },
		{ X: "Março", Y: 40.00 },
		{ X: "Abril", Y: 34.00 },
		{ X: "Maio", Y: 40.25 },
		{ X: "Junho", Y: 28.56 },
		{ X: "Julho", Y: 18.57 },
		{ X: "Agosto", Y: 34.00 },
		{ X: "Setembro", Y: 40.89 },
		{ X: "Outubro", Y: 12.57 },
		{ X: "Novembro", Y: 28.24 },
		{ X: "Dezembro", Y: 18.00 }
		
		]
	};
	var graphdata2 = {
		linecolor: "#04ba41",
		title: "Receitas",
		values: [
		{ X: "Janeiro", Y:parseFloat(saldo_mes[1])},
		{ X: "Fevereiro", Y: 30.00 },
		{ X: "Março", Y: 10.00 },
		{ X: "Abril", Y: 344.00 },
		{ X: "Maio", Y: 50.25 },
		{ X: "Junho", Y: 38.56 },
		{ X: "Julho", Y: 28.57 },
		{ X: "Agosto", Y: 44.00 },
		{ X: "Setembro", Y: 20.89 },
		{ X: "Outubro", Y: 2.57 },
		{ X: "Novembro", Y: 38.24 },
		{ X: "Dezembro", Y: 38.00 }
		
		]
	};
	
	
	$(function () {
		$('#dados_grafico_despesa').val('<?=$dados_meses_despesas?>'); 
		var dados = $('#dados_grafico_despesa').val();
        saldo_mes = dados.split('-'); 

		$('#dados_grafico_receita').val('<?=$dados_meses_receitas?>'); 
		var dados_rec = $('#dados_grafico_receita').val();
        saldo_mes_rec = dados_rec.split('-'); 
		
		
		
		$("#Linegraph").SimpleChart({
			ChartType: "Line",
			toolwidth: "50",
			toolheight: "25",
			axiscolor: "#E6E6E6",
			textcolor: "#6E6E6E",
			showlegends: true,
			data: [ graphdata2, graphdata1],
			legendsize: "40",
			legendposition: 'bottom',
			xaxislabel: 'Meses',
			title: 'Despesas / Recebimentos',
			yaxislabel: 'Valores'
		});
		
	});

</script>
<!-- //for index page weekly sales java script -->
