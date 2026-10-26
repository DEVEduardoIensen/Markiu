/**
 * Astah UML State Machine Diagrams Generator
 * 100% Faithful Replica of Astah UML Desktop Software
 * Focus: Questions 3 to 11
 */

const DIAGRAMS = {
  3: {
    id: 3,
    title: "3. Máquina de Lavar Roupas (Running e Queda de Energia)",
    shortTitle: "3: Máq. Lavar",
    diagramName: "Statemachine Diagram_Washer",
    diagramType: "stm",
    width: 980,
    height: 650,
    description: `Exercício 3 - Máquina de Lavar Roupas:
• Ao ser iniciada, a máquina entra no estado composto 'RUNNING' (Execução).
• Realiza sequencialmente 3 etapas: Washing (Lavagem) -> Rinsing (Enxágue) -> Spinning (Centrifugação).
• Durante qualquer etapa pode ocorrer 'Queda de energia', levando ao estado 'POWER OFF'.
• Ao restabelecer a energia elétrica, retorna ao estado de execução através do mecanismo de histórico (H - Deep History), retomando o funcionamento a partir da etapa adequada.`,
    render: function(w, h) {
      return `
        <!-- Astah Outer Frame -->
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- 1. Estado Inicial Global -->
        ${renderInitial(110, 60)}
        ${renderLine(117, 60, 220, 60, "iniciar ciclo", { lx: 168, ly: 50 })}

        <!-- 2. Estado Composto: RUNNING (EXECUÇÃO) -->
        ${renderComposite(220, 36, 740, 430, "RUNNING (EXECUÇÃO)")}

        <!-- Pseudo-Estado de Histórico (H) -->
        ${renderHistory(265, 110, "H")}
        
        <!-- Seta interna do histórico para Washing -->
        ${renderLine(275, 110, 375, 135, "[primeira vez]", { lx: 325, ly: 110 })}

        <!-- 2.1 Sub-Estado: WASHING (LAVAGEM) -->
        ${renderState({
          x: 375, y: 105, w: 260, h: 58,
          title: "WASHING (LAVAGEM)",
          lines: [
            "entry / ENCHER DE ÁGUA E SABÃO",
            "do / AGITAR ROUPAS"
          ]
        })}

        <!-- Seta Lavagem -> Enxágue -->
        ${renderLine(505, 163, 505, 215, "lavagem concluída", { lx: 575, ly: 190 })}

        <!-- 2.2 Sub-Estado: RINSING (ENXÁGUE) -->
        ${renderState({
          x: 375, y: 215, w: 260, h: 58,
          title: "RINSING (ENXÁGUE)",
          lines: [
            "entry / DRENAR E ENCHER COM AMACIANTE",
            "do / ENXAGUAR ROUPAS"
          ]
        })}

        <!-- Seta Enxágue -> Centrifugação -->
        ${renderLine(505, 273, 505, 325, "enxágue concluído", { lx: 575, ly: 300 })}

        <!-- 2.3 Sub-Estado: SPINNING (CENTRIFUGAÇÃO) -->
        ${renderState({
          x: 375, y: 325, w: 260, h: 58,
          title: "SPINNING (CENTRIFUGAÇÃO)",
          lines: [
            "entry / DRENAR ÁGUA TOTAL",
            "do / CENTRIFUGAR EM ALTA ROTAÇÃO"
          ]
        })}

        <!-- Seta Centrifugação -> Ciclo Finalizado -->
        ${renderLine(635, 354, 760, 354, "centrifugação concluída", { lx: 695, ly: 344 })}

        <!-- Sub-Estado: CICLO FINALIZADO -->
        ${renderState({
          x: 760, y: 334, w: 140, h: 42,
          title: "CICLO FINALIZADO",
          lines: ["entry / EMITIR ALERTA"]
        })}

        <!-- Seta -> Final interno ao RUNNING -->
        ${renderLine(830, 376, 830, 411, "ciclo concluído", { lx: 880, ly: 395 })}
        ${renderFinal(830, 420)}

        <!-- === TRATAMENTO DE INTERRUPÇÃO DE ENERGIA === -->

        <!-- Queda de energia: sai da borda do RUNNING para POWER OFF -->
        ${renderPolyline([
          { x: 220, y: 350 },
          { x: 110, y: 350 },
          { x: 110, y: 510 }
        ], "Queda de energia", { lx: 115, ly: 340 })}

        <!-- Estado: POWER OFF -->
        ${renderState({
          x: 18, y: 510, w: 184, h: 58,
          title: "POWER OFF",
          lines: [
            "entry / SALVAR ETAPA ATUAL",
            "do / INTERROMPER MOTORES"
          ]
        })}

        <!-- Retorno de POWER OFF para o Histórico (H) -->
        ${renderPolyline([
          { x: 60, y: 510 },
          { x: 60, y: 110 },
          { x: 255, y: 110 }
        ], "Energia restabelecida", { lx: 155, ly: 100 })}
      `;
    }
  },

  4: {
    id: 4,
    title: "4. Sistema de Vendas de Loja (Formas de Pagamento)",
    shortTitle: "4: Venda de Loja",
    diagramName: "Statemachine Vendas",
    diagramType: "stm",
    width: 1040,
    height: 660,
    description: `Exercício 4 - Venda de Loja:
• O atendente inclui itens à compra (auto-transição em 'Venda Aberta').
• Ao finalizar a venda, escolhe uma das três opções: Boleto, Cartão ou Dinheiro.
• Processa a forma escolhida, confirma o pagamento com emissão de nota e finaliza a compra.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(40, 118)}
        ${renderLine(47, 118, 175, 118, "iniciar atendimento", { lx: 108, ly: 108 })}

        <!-- Estado: VENDA ABERTA -->
        ${renderState({
          x: 175, y: 88, w: 200, h: 58,
          title: "VENDA ABERTA",
          lines: [
            "entry / INICIAR NOVO CARRINHO",
            "do / AGUARDAR ITENS"
          ]
        })}

        <!-- Auto-transição: Incluir item (bem espaçado do topo) -->
        ${renderPolyline([
          { x: 240, y: 88 },
          { x: 240, y: 48 },
          { x: 310, y: 48 },
          { x: 310, y: 88 }
        ], "incluir item / somar ao subtotal", { lx: 275, ly: 40 })}

        <!-- Seta Venda Aberta -> Escolhendo Forma de Pagamento -->
        ${renderLine(375, 118, 475, 118, "finalizar venda", { lx: 425, ly: 108 })}

        <!-- Estado: ESCOLHENDO FORMA DE PAGAMENTO -->
        ${renderState({
          x: 475, y: 90, w: 240, h: 52,
          title: "ESCOLHENDO FORMA DE PAGAMENTO",
          lines: ["entry / APRESENTAR VALOR TOTAL"]
        })}

        <!-- Seta -> Decisão -->
        ${renderLine(595, 142, 595, 195)}
        ${renderDecision(595, 205, 16)}

        <!-- 1. Ramo BOLETO -->
        ${renderPolyline([
          { x: 587, y: 205 },
          { x: 210, y: 205 },
          { x: 210, y: 260 }
        ], "escolher boleto", { lx: 360, ly: 195 })}

        ${renderState({
          x: 110, y: 260, w: 200, h: 58,
          title: "PAGAMENTO EM BOLETO",
          lines: [
            "entry / GERAR CÓDIGO BARRAS",
            "do / AGUARDAR COMPENSAÇÃO"
          ]
        })}

        <!-- 2. Ramo CARTÃO -->
        ${renderLine(595, 213, 595, 260, "escolher cartão", { lx: 648, ly: 238 })}

        ${renderState({
          x: 495, y: 260, w: 200, h: 58,
          title: "PAGAMENTO EM CARTÃO",
          lines: [
            "entry / INSERIR NA MAQUININHA",
            "do / PROCESSAR AUTORIZAÇÃO"
          ]
        })}

        <!-- 3. Ramo DINHEIRO -->
        ${renderPolyline([
          { x: 603, y: 205 },
          { x: 850, y: 205 },
          { x: 850, y: 260 }
        ], "escolher dinheiro", { lx: 730, ly: 195 })}

        ${renderState({
          x: 740, y: 260, w: 220, h: 58,
          title: "PAGAMENTO EM DINHEIRO",
          lines: [
            "entry / RECEBER VALOR",
            "do / CALCULAR E ENTREGAR TROCO"
          ]
        })}

        <!-- Convergência para PAGAMENTO CONFIRMADO -->
        ${renderPolyline([
          { x: 210, y: 318 },
          { x: 210, y: 416 },
          { x: 512, y: 416 }
        ], "boleto compensado", { lx: 310, ly: 406 })}

        ${renderLine(595, 318, 595, 390, "transação autorizada", { lx: 655, ly: 355 })}

        ${renderPolyline([
          { x: 850, y: 318 },
          { x: 850, y: 416 },
          { x: 678, y: 416 }
        ], "dinheiro recebido", { lx: 780, ly: 406 })}

        <!-- Estado: PAGAMENTO CONFIRMADO -->
        ${renderState({
          x: 512, y: 390, w: 166, h: 52,
          title: "PAGAMENTO CONFIRMADO",
          lines: ["entry / EMITIR NOTA FISCAL"]
        })}

        <!-- Seta -> Venda Finalizada -->
        ${renderLine(595, 442, 595, 500, "concluir venda", { lx: 640, ly: 470 })}

        <!-- Estado: VENDA FINALIZADA -->
        ${renderState({
          x: 529, y: 500, w: 132, h: 32,
          title: "VENDA FINALIZADA",
          lines: []
        })}

        <!-- Seta -> Final -->
        ${renderLine(595, 532, 595, 590)}
        ${renderFinal(595, 600)}
      `;
    }
  },

  5: {
    id: 5,
    title: "5. Processo de Pagamento de Mensalidade (Clube Social)",
    shortTitle: "5: Mensalidade Clube",
    diagramName: "Statemachine Mensalidades",
    diagramType: "stm",
    width: 900,
    height: 680,
    description: `Exercício 5 - Clube Social:
1. Consultar o sócio que deseja pagar mensalidades.
2. Após a consulta do sócio, consultar a(s) mensalidade(s) por ele devida(s).
3. Se houver alguma mensalidade em atraso, calcular os juros referentes ao atraso do pagamento.
4. Em seguida, informar quais mensalidades o sócio deseja quitar.
5. Finalmente, quitar a(s) mensalidade(s) informada(s) e dar baixa.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(450, 45)}
        ${renderLine(450, 53, 450, 95, "solicitar pagamento", { lx: 510, ly: 75 })}

        <!-- Estado: CONSULTANDO SÓCIO -->
        ${renderState({
          x: 337, y: 95, w: 226, h: 52,
          title: "CONSULTANDO SÓCIO",
          lines: ["entry / BUSCAR CADASTRO DO SÓCIO"]
        })}

        <!-- Seta -> Consultar Mensalidades -->
        ${renderLine(450, 147, 450, 200, "sócio localizado", { lx: 505, ly: 175 })}

        <!-- Estado: CONSULTANDO MENSALIDADES DEVIDAS -->
        ${renderState({
          x: 325, y: 200, w: 250, h: 52,
          title: "CONSULTANDO MENSALIDADES DEVIDAS",
          lines: ["entry / LISTAR MENSALIDADES EM ABERTO"]
        })}

        <!-- Seta -> Decisão de atraso -->
        ${renderLine(450, 252, 450, 305, "mensalidades listadas", { lx: 520, ly: 280 })}
        ${renderDecision(450, 315, 18)}

        <!-- Ramo Esquerdo: Com Atraso -> Calcular Juros -->
        ${renderPolyline([
          { x: 441, y: 315 },
          { x: 220, y: 315 },
          { x: 220, y: 375 }
        ], "[mensalidade em atraso]", { lx: 290, ly: 305 })}

        ${renderState({
          x: 117, y: 375, w: 206, h: 58,
          title: "CALCULANDO JUROS DE ATRASO",
          lines: [
            "entry / APLICAR MULTA E JUROS",
            "do / ATUALIZAR VALOR TOTAL"
          ]
        })}

        <!-- Ramo Direito: Sem Atraso -->
        ${renderPolyline([
          { x: 459, y: 315 },
          { x: 680, y: 315 },
          { x: 680, y: 480 },
          { x: 573, y: 480 }
        ], "[sem atraso]", { lx: 580, ly: 305 })}

        <!-- De Calcular Juros para Selecionar Mensalidades -->
        ${renderPolyline([
          { x: 220, y: 433 },
          { x: 220, y: 480 },
          { x: 327, y: 480 }
        ], "valores atualizados", { lx: 240, ly: 495 })}

        <!-- Estado: INFORMANDO MENSALIDADES A QUITAR -->
        ${renderState({
          x: 327, y: 455, w: 246, h: 48,
          title: "SELECIONANDO MENSALIDADES",
          lines: ["do / INFORMAR MENSALIDADES A QUITAR"]
        })}

        <!-- Seta -> Quitando Mensalidades -->
        ${renderLine(450, 503, 450, 555, "confirmar quitação", { lx: 515, ly: 530 })}

        <!-- Estado: QUITANDO MENSALIDADES INFORMADAS -->
        ${renderState({
          x: 323, y: 555, w: 254, h: 52,
          title: "QUITANDO MENSALIDADES",
          lines: ["entry / EFETIVAR PAGAMENTO E DAR BAIXA"]
        })}

        <!-- Seta -> Final -->
        ${renderLine(450, 607, 450, 645, "mensalidades quitadas", { lx: 525, ly: 630 })}
        ${renderFinal(450, 655)}
      `;
    }
  },

  6: {
    id: 6,
    title: "6. ATM Terminal Bancário de Autoatendimento",
    shortTitle: "6: ATM Terminal",
    diagramName: "Statemachine ATM_Terminal",
    diagramType: "stm",
    width: 1080,
    height: 700,
    description: `Exercício 6 - Terminal Bancário ATM:
• Inicialização com rotina de autoteste.
• Estado Ocioso aguardando inserção do cartão.
• Estado Composto 'ATENDIMENTO AO CLIENTE': Autenticação -> Seleção da Operação -> Execução da Transação -> Encerramento e ejeção.
• Tratamento de falhas: transição para Indisponível diante de erro de hardware ou término de cédulas; e recuperação operacional através do estado de Manutenção por técnico.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(70, 115)}
        ${renderLine(78, 115, 140, 115)}

        <!-- Estado: INICIALIZAÇÃO -->
        ${renderState({
          x: 140, y: 85, w: 186, h: 58,
          title: "INICIALIZAÇÃO",
          lines: [
            "entry / EXECUTAR AUTOTESTE",
            "do / CHECAR DISPOSITIVOS"
          ]
        })}

        <!-- Autoteste OK -> Ocioso -->
        ${renderLine(326, 115, 436, 115, "[autoteste OK]", { lx: 381, ly: 105 })}

        <!-- Falha no autoteste -> Indisponível -->
        ${renderLine(233, 143, 233, 250, "[falha no autoteste]", { lx: 295, ly: 195 })}

        <!-- Estado: OCIOSO (IDLE) -->
        ${renderState({
          x: 436, y: 85, w: 168, h: 58,
          title: "OCIOSO (IDLE)",
          lines: [
            "entry / EXIBIR TELA INICIAL",
            "entry / AGUARDAR CARTÃO"
          ]
        })}

        <!-- Transição Ocioso -> Atendimento ao Cliente -->
        ${renderLine(604, 115, 710, 115, "inserir cartão", { lx: 657, ly: 105 })}

        <!-- Grande Estado Composto: ATENDIMENTO AO CLIENTE -->
        ${renderComposite(710, 40, 340, 600, "ATENDIMENTO AO CLIENTE")}

        <!-- Inicial Interno -->
        ${renderInitial(880, 85)}
        ${renderLine(880, 92, 880, 125)}

        <!-- Sub-Estado: AUTENTICAÇÃO -->
        ${renderState({
          x: 760, y: 125, w: 240, h: 58,
          title: "AUTENTICAÇÃO",
          lines: [
            "entry / SOLICITAR SENHA E BIOMETRIA",
            "do / VALIDAR CREDENCIAIS"
          ]
        })}

        <!-- Seta -> Seleção da Operação -->
        ${renderLine(880, 183, 880, 240, "[credenciais válidas]", { lx: 880, ly: 215 })}

        <!-- Sub-Estado: SELEÇÃO DA OPERAÇÃO -->
        ${renderState({
          x: 775, y: 240, w: 210, h: 52,
          title: "SELEÇÃO DA OPERAÇÃO",
          lines: [
            "entry / EXIBIR MENU DE SERVIÇOS",
            "do / AGUARDAR ESCOLHA"
          ]
        })}

        <!-- Seta -> Execução da Transação -->
        ${renderLine(880, 292, 880, 350, "operação escolhida", { lx: 880, ly: 325 })}

        <!-- Sub-Estado: EXECUÇÃO DA TRANSAÇÃO -->
        ${renderState({
          x: 767, y: 350, w: 226, h: 68,
          title: "EXECUÇÃO DA TRANSAÇÃO",
          lines: [
            "entry / PROCESSAR TRANSAÇÃO",
            "do / DISPENSAR CÉDULAS OU SALDO",
            "exit / REGISTRAR LOG DE AUDITORIA"
          ]
        })}

        <!-- Seta -> Finalização -->
        ${renderLine(880, 418, 880, 480, "transação finalizada", { lx: 880, ly: 450 })}

        <!-- Sub-Estado: FINALIZAÇÃO DO ATENDIMENTO -->
        ${renderState({
          x: 788, y: 480, w: 184, h: 55,
          title: "FINALIZAÇÃO DA SESSÃO",
          lines: [
            "entry / EJETAR CARTÃO",
            "entry / EMITIR COMPROVANTE"
          ]
        })}

        <!-- Retorno de Atendimento para Ocioso -->
        ${renderPolyline([
          { x: 788, y: 510 },
          { x: 520, y: 510 },
          { x: 520, y: 143 }
        ], "cartão removido pelo cliente", { lx: 550, ly: 500 })}

        <!-- === TRATAMENTO DE FALHAS / INDISPONIBILIDADE / MANUTENÇÃO === -->

        <!-- Seta para Indisponível em caso de falha -->
        ${renderPolyline([
          { x: 490, y: 143 },
          { x: 490, y: 275 },
          { x: 345, y: 275 }
        ], "falha de hardware / sem cédulas", { lx: 440, ly: 220 })}

        <!-- Estado: INDISPONÍVEL -->
        ${renderState({
          x: 121, y: 250, w: 224, h: 55,
          title: "INDISPONÍVEL",
          lines: [
            "entry / EXIBIR 'FORA DE SERVIÇO'",
            "entry / NOTIFICAR CENTRAL BANCÁRIA"
          ]
        })}

        <!-- Transição Indisponível -> Manutenção -->
        ${renderLine(233, 305, 233, 380, "técnico autenticado", { lx: 233, ly: 345 })}

        <!-- Estado: MANUTENÇÃO -->
        ${renderState({
          x: 120, y: 380, w: 226, h: 68,
          title: "MANUTENÇÃO",
          lines: [
            "entry / ABRIR COFRE E MÓDULOS",
            "do / REPARAR E REPOR CÉDULAS",
            "do / EXECUTAR AUTOTESTE TÉCNICO"
          ]
        })}

        <!-- Transição Manutenção Concluída -> Inicialização (topo limpo) -->
        ${renderPolyline([
          { x: 120, y: 415 },
          { x: 30, y: 415 },
          { x: 30, y: 60 },
          { x: 233, y: 60 },
          { x: 233, y: 85 }
        ], "reset / manutenção concluída", { lx: 130, ly: 50 })}
      `;
    }
  },

  7: {
    id: 7,
    title: "7. Fechadura Inteligente IoT (Smart Key)",
    shortTitle: "7: Fechadura IoT",
    diagramName: "Statemachine Fechadura_IoT",
    diagramType: "stm",
    width: 960,
    height: 680,
    description: `Exercício 7 - Fechadura Inteligente IoT:
• Smart Key aproximada -> Leitura do código RFID -> tenta conectar ao servidor.
• Servidor Online: valida remotamente (válida -> desbloqueia; inválida -> nega acesso).
• Servidor Offline (Falha de conexão): consulta registros internos (cadastrada e permitida -> desbloqueia; não encontrada -> nega acesso).`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(480, 45)}
        ${renderLine(480, 53, 480, 95)}

        <!-- Estado: AGUARDANDO SMART KEY -->
        ${renderState({
          x: 376, y: 95, w: 208, h: 52,
          title: "STANDBY / AGUARDANDO CHAVE",
          lines: ["entry / ATIVAR SENSOR RFID"]
        })}

        <!-- Seta -> Leitura RFID -->
        ${renderLine(480, 147, 480, 200, "chave aproximada", { lx: 535, ly: 175 })}

        <!-- Estado: LEITURA DO CÓDIGO RFID -->
        ${renderState({
          x: 382, y: 200, w: 196, h: 52,
          title: "LEITURA DO CÓDIGO RFID",
          lines: ["entry / CAPTURAR CÓDIGO RFID"]
        })}

        <!-- Seta -> Decisão de Conexão -->
        ${renderLine(480, 252, 480, 305, "tentar conexão", { lx: 530, ly: 280 })}
        ${renderDecision(480, 315, 18)}

        <!-- Ramo Esquerdo: Conexão Estabelecida -->
        ${renderPolyline([
          { x: 471, y: 315 },
          { x: 260, y: 315 },
          { x: 260, y: 375 }
        ], "[conexão com servidor OK]", { lx: 320, ly: 305 })}

        ${renderState({
          x: 140, y: 375, w: 240, h: 55,
          title: "VALIDAÇÃO REMOTA (SERVIDOR)",
          lines: [
            "entry / ENVIAR CÓDIGO RFID",
            "do / AGUARDAR STATUS DA CREDENCIAL"
          ]
        })}

        <!-- Decisão Servidor Válida/Inválida -->
        ${renderLine(260, 430, 260, 470)}
        ${renderDecision(260, 480, 18)}

        <!-- Ramo Direito: Falha de Conexão (Modo Offline) -->
        ${renderPolyline([
          { x: 489, y: 315 },
          { x: 710, y: 315 },
          { x: 710, y: 375 }
        ], "[falha de conexão]", { lx: 640, ly: 305 })}

        ${renderState({
          x: 582, y: 375, w: 256, h: 55,
          title: "CONSULTA INTERNA (OFFLINE)",
          lines: ["entry / BUSCAR RFID NA MEMÓRIA INTERNA"]
        })}

        <!-- Decisão Registro Local -->
        ${renderLine(710, 430, 710, 470)}
        ${renderDecision(710, 480, 18)}

        <!-- === RESULTADOS: ACESSO AUTORIZADO (DESBLOQUEIO) === -->
        
        <!-- Do Servidor para Desbloqueio (ramo direito da decisão) -->
        ${renderPolyline([
          { x: 269, y: 480 },
          { x: 420, y: 480 },
          { x: 420, y: 535 }
        ], "[chave válida]", { lx: 350, ly: 470 })}

        <!-- Do Offline para Desbloqueio (ramo esquerdo da decisão) -->
        ${renderPolyline([
          { x: 701, y: 480 },
          { x: 540, y: 480 },
          { x: 540, y: 535 }
        ], "[chave encontrada]", { lx: 615, ly: 470 })}

        <!-- Estado Central: DESBLOQUEIO DA FECHADURA -->
        ${renderState({
          x: 373, y: 535, w: 214, h: 52,
          title: "DESBLOQUEIO DA FECHADURA",
          lines: [
            "entry / ACIONAR MOTOR DA TRAVA",
            "entry / EMITIR BEEP DE LIBERAÇÃO"
          ]
        })}

        <!-- Seta Desbloqueio -> Final -->
        ${renderLine(480, 587, 480, 635, "acesso liberado", { lx: 535, ly: 615 })}
        ${renderFinal(480, 645)}

        <!-- === RESULTADO: ACESSO NEGADO (ESQUERDA - SERVIDOR) === -->
        ${renderPolyline([
          { x: 251, y: 480 },
          { x: 170, y: 480 },
          { x: 170, y: 535 }
        ], "[chave inválida]", { lx: 170, ly: 470 })}

        ${renderState({
          x: 57, y: 535, w: 226, h: 52,
          title: "ACESSO NEGADO",
          lines: [
            "entry / SINALIZAR LED VERMELHO",
            "entry / MANTER FECHADURA TRAVADA"
          ]
        })}

        <!-- Seta Negado -> Final -->
        ${renderLine(170, 587, 170, 635)}
        ${renderFinal(170, 645)}

        <!-- === RESULTADO: ACESSO NEGADO (DIREITA - OFFLINE) === -->
        ${renderPolyline([
          { x: 719, y: 480 },
          { x: 790, y: 480 },
          { x: 790, y: 535 }
        ], "[não encontrada]", { lx: 790, ly: 470 })}

        ${renderState({
          x: 677, y: 535, w: 226, h: 52,
          title: "ACESSO NEGADO",
          lines: [
            "entry / SINALIZAR LED VERMELHO",
            "entry / MANTER FECHADURA TRAVADA"
          ]
        })}

        ${renderLine(790, 587, 790, 635)}
        ${renderFinal(790, 645)}
      `;
    }
  },

  8: {
    id: 8,
    title: "8. Processo de Locação de Veículo",
    shortTitle: "8: Locação Veículo",
    diagramName: "Statemachine Locacao_Veiculos",
    diagramType: "stm",
    width: 900,
    height: 680,
    description: `Exercício 8 - Locação de Veículo:
• Selecionar opção de locação -> carrega todos os clientes registrados.
• Apresenta os veículos disponíveis (descrição, modelo e marca).
• Funcionário seleciona cliente.
• Funcionário seleciona automóvel.
• Funcionário manda gerar a locação do automóvel selecionado.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(450, 45)}
        ${renderLine(450, 53, 450, 95, "selecionar locação de veículos", { lx: 525, ly: 75 })}

        <!-- Estado: CARREGANDO CLIENTES REGISTRADOS -->
        ${renderState({
          x: 315, y: 95, w: 270, h: 52,
          title: "CARREGANDO CLIENTES REGISTRADOS",
          lines: ["entry / BUSCAR CLIENTES NA BASE DE DADOS"]
        })}

        <!-- Seta -> Apresentando Veículos Disponíveis -->
        ${renderLine(450, 147, 450, 200, "clientes carregados", { lx: 515, ly: 175 })}

        <!-- Estado: APRESENTANDO VEÍCULOS DISPONÍVEIS -->
        ${renderState({
          x: 315, y: 200, w: 270, h: 60,
          title: "APRESENTANDO VEÍCULOS DISPONÍVEIS",
          lines: [
            "entry / LISTAR VEÍCULOS DISPONÍVEIS",
            "do / EXIBIR DESCRIÇÃO, MODELO E MARCA"
          ]
        })}

        <!-- Seta -> Aguardando Seleção do Cliente -->
        ${renderLine(450, 260, 450, 315, "listagem exibida", { lx: 505, ly: 290 })}

        <!-- Estado: AGUARDANDO SELEÇÃO DO CLIENTE -->
        ${renderState({
          x: 315, y: 315, w: 270, h: 48,
          title: "AGUARDANDO SELEÇÃO DO CLIENTE",
          lines: ["do / FUNCIONÁRIO SELECIONA O CLIENTE"]
        })}

        <!-- Seta -> Aguardando Seleção do Automóvel -->
        ${renderLine(450, 363, 450, 415, "cliente selecionado", { lx: 515, ly: 390 })}

        <!-- Estado: AGUARDANDO SELEÇÃO DO AUTOMÓVEL -->
        ${renderState({
          x: 315, y: 415, w: 270, h: 48,
          title: "AGUARDANDO SELEÇÃO DO AUTOMÓVEL",
          lines: ["do / FUNCIONÁRIO SELECIONA O AUTOMÓVEL"]
        })}

        <!-- Seta -> Gerando Locação -->
        ${renderLine(450, 463, 450, 515, "mandar gerar locação", { lx: 520, ly: 490 })}

        <!-- Estado: GERANDO LOCAÇÃO DO VEÍCULO -->
        ${renderState({
          x: 315, y: 515, w: 270, h: 55,
          title: "GERANDO LOCAÇÃO DO VEÍCULO",
          lines: [
            "entry / PROCESSAR CONTRATO DE LOCAÇÃO",
            "entry / VINCULAR CLIENTE AO VEÍCULO"
          ]
        })}

        <!-- Seta -> Final -->
        ${renderLine(450, 570, 450, 620, "locação finalizada", { lx: 510, ly: 595 })}
        ${renderFinal(450, 630)}
      `;
    }
  },

  9: {
    id: 9,
    title: "9. Realizar Leilão via Internet",
    shortTitle: "9: Leilão Web",
    diagramName: "Statemachine Leilao_Internet",
    diagramType: "stm",
    width: 960,
    height: 700,
    description: `Exercício 9 - Leilão via Internet:
• Apresenta leilões abertos -> leiloeiro seleciona leilão -> carrega itens.
• Escolhe item e anuncia.
• Lances chegam e são registrados com reinício do timer de espera.
• Tempo esgotado: verifica ofertas (anuncia vencedor ou encerra anúncio).
• Verifica se ainda há itens (anuncia novo item ou encerra leilão).`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(100, 65)}
        ${renderLine(108, 65, 180, 65, "solicitar serviço", { lx: 140, ly: 55 })}

        <!-- Estado: APRESENTANDO LEILÕES NÃO ENCERRADOS -->
        ${renderState({
          x: 180, y: 40, w: 260, h: 52,
          title: "APRESENTANDO LEILÕES ABERTOS",
          lines: ["entry / LISTAR LEILÕES NÃO ENCERRADOS"]
        })}

        <!-- Seta -> Carregando Itens -->
        ${renderLine(440, 65, 520, 65, "selecionar leilão", { lx: 480, ly: 55 })}

        <!-- Estado: CARREGANDO ITENS DO LEILÃO -->
        ${renderState({
          x: 520, y: 40, w: 270, h: 52,
          title: "CARREGANDO ITENS DO LEILÃO",
          lines: ["entry / CARREGAR ITENS A SEREM LEILOADOS"]
        })}

        <!-- Seta -> Aguardando Escolha do Item -->
        ${renderLine(655, 92, 655, 140, "itens carregados", { lx: 705, ly: 115 })}

        <!-- Estado: AGUARDANDO ESCOLHA DO ITEM -->
        ${renderState({
          x: 555, y: 140, w: 200, h: 48,
          title: "ESCOLHENDO ITEM A LEILOAR",
          lines: ["do / LEILOEIRO SELECIONA ITEM"]
        })}

        <!-- Seta -> Estado Composto LEILÃO DO ITEM -->
        ${renderLine(655, 188, 655, 235, "anunciar item", { lx: 700, ly: 212 })}

        <!-- Estado Composto: LEILÃO DO ITEM ATIVO -->
        ${renderComposite(120, 235, 820, 310, "LEILÃO DO ITEM ATIVO")}

        <!-- Sub-Estado: ANUNCIANDO ITEM -->
        ${renderState({
          x: 384, y: 280, w: 252, h: 55,
          title: "ANUNCIANDO ITEM",
          lines: [
            "entry / INICIAR TEMPO MÁXIMO DE ESPERA",
            "do / EXIBIR ITEM AOS PARTICIPANTES"
          ]
        })}

        <!-- Auto-transição / Loop de Lances (lateral direita sem colisão com cabeçalho) -->
        ${renderPolyline([
          { x: 636, y: 295 },
          { x: 680, y: 295 },
          { x: 680, y: 325 },
          { x: 636, y: 325 }
        ], "novo lance / reiniciar timer", { lx: 765, ly: 312 })}

        <!-- Seta ao esgotar o tempo -> Decisão -->
        ${renderLine(510, 335, 510, 390, "tempo máximo atingido", { lx: 585, ly: 365 })}
        ${renderDecision(510, 400, 18)}

        <!-- Ramo: Houve Ofertas -> Anunciar Vencedor -->
        ${renderPolyline([
          { x: 501, y: 400 },
          { x: 270, y: 400 },
          { x: 270, y: 450 }
        ], "[houve ofertas]", { lx: 350, ly: 390 })}

        ${renderState({
          x: 140, y: 450, w: 260, h: 52,
          title: "ANUNCIANDO VENCEDOR",
          lines: ["entry / DECLARAR MAIOR LANCE VENCEDOR"]
        })}

        <!-- Ramo: Sem Ofertas -> Encerrar Anúncio -->
        ${renderPolyline([
          { x: 519, y: 400 },
          { x: 770, y: 400 },
          { x: 770, y: 450 }
        ], "[não houve ofertas]", { lx: 690, ly: 390 })}

        ${renderState({
          x: 640, y: 450, w: 260, h: 52,
          title: "ENCERRANDO ANÚNCIO DO ITEM",
          lines: ["entry / FINALIZAR ANÚNCIO SEM VENCEDOR"]
        })}

        <!-- Saídas do Composto convergindo para Decisão de Mais Itens -->
        ${renderPolyline([
          { x: 270, y: 502 },
          { x: 270, y: 585 },
          { x: 501, y: 585 }
        ])}

        ${renderPolyline([
          { x: 770, y: 502 },
          { x: 770, y: 585 },
          { x: 519, y: 585 }
        ])}

        <!-- Decisão: Ainda há itens a anunciar? -->
        ${renderDecision(510, 585, 18)}

        <!-- Loop de volta se houver mais itens -->
        ${renderPolyline([
          { x: 519, y: 585 },
          { x: 890, y: 585 },
          { x: 890, y: 165 },
          { x: 755, y: 165 }
        ], "[ainda há itens a anunciar]", { lx: 890, ly: 375 })}

        <!-- Fim do leilão se acabaram os itens -->
        ${renderLine(510, 594, 510, 640, "[todos os itens leiloados]", { lx: 590, ly: 620 })}

        <!-- Estado: LEILÃO ENCERRADO -->
        ${renderState({
          x: 440, y: 640, w: 140, h: 32,
          title: "LEILÃO ENCERRADO",
          lines: []
        })}

        ${renderLine(580, 656, 650, 656)}
        ${renderFinal(660, 656)}
      `;
    }
  },

  10: {
    id: 10,
    title: "10. Processo de Pagamento de Diárias (Hotelaria)",
    shortTitle: "10: Diárias Hotel",
    diagramName: "Statemachine Hotelaria_Diarias",
    diagramType: "stm",
    width: 960,
    height: 720,
    description: `Exercício 10 - Hotelaria:
• Hóspede informa número do quarto -> consulta hóspede e diárias devidas do aluguel.
• Apresenta listagem ao funcionário -> quita diárias devidas.
• Se tiver havido solicitação de serviços no período, quita também.
• Se houver consumos de frigobar, quita também.
• Finaliza o check-out e encerra o processo.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(480, 45)}
        ${renderLine(480, 53, 480, 95)}

        <!-- Estado: AGUARDANDO NÚMERO DO QUARTO -->
        ${renderState({
          x: 343, y: 95, w: 274, h: 48,
          title: "AGUARDANDO QUARTO",
          lines: ["do / HÓSPEDE INFORMA NÚMERO DO QUARTO"]
        })}

        <!-- Seta -> Consultando Hóspede e Diárias -->
        ${renderLine(480, 143, 480, 195, "quarto informado", { lx: 535, ly: 170 })}

        <!-- Estado: CONSULTANDO HÓSPEDE E DIÁRIAS -->
        ${renderState({
          x: 351, y: 195, w: 258, h: 55,
          title: "CONSULTANDO HÓSPEDE E DIÁRIAS",
          lines: [
            "entry / LOCALIZAR HÓSPEDE DO QUARTO",
            "entry / BUSCAR TODAS AS DIÁRIAS DEVIDAS"
          ]
        })}

        <!-- Seta -> Apresentando Diárias -->
        ${renderLine(480, 250, 480, 305, "dados encontrados", { lx: 540, ly: 280 })}

        <!-- Estado: APRESENTANDO DIÁRIAS AO FUNCIONÁRIO -->
        ${renderState({
          x: 349, y: 305, w: 262, h: 48,
          title: "APRESENTANDO DIÁRIAS AO FUNCIONÁRIO",
          lines: ["do / EXIBIR RELATÓRIO DE DIÁRIAS NA TELA"]
        })}

        <!-- Seta -> Quitando Diárias -->
        ${renderLine(480, 353, 480, 410, "quitar diárias", { lx: 525, ly: 385 })}

        <!-- Estado: QUITANDO DIÁRIAS -->
        ${renderState({
          x: 352, y: 410, w: 256, h: 48,
          title: "QUITANDO DIÁRIAS",
          lines: ["entry / EFETIVAR PAGAMENTO DAS DIÁRIAS"]
        })}

        <!-- Seta -> Decisão de Serviços Extras -->
        ${renderLine(480, 458, 480, 500)}
        ${renderDecision(480, 510, 18)}

        <!-- Ramo Esquerdo: Houve Serviços Extras -->
        ${renderPolyline([
          { x: 471, y: 510 },
          { x: 210, y: 510 },
          { x: 210, y: 555 }
        ], "[houve serviços solicitados]", { lx: 290, ly: 500 })}

        ${renderState({
          x: 74, y: 555, w: 272, h: 48,
          title: "QUITANDO SERVIÇOS DO HOTEL",
          lines: ["entry / COBRAR SERVIÇOS DE QUARTO/EXTRA"]
        })}

        <!-- Ramo Direto se não houver serviços vai para Frigobar -->
        ${renderLine(480, 519, 480, 560, "[sem serviços extras]", { lx: 545, ly: 540 })}

        <!-- Decisão Frigobar -->
        ${renderDecision(480, 570, 18)}

        <!-- Retorno dos Serviços para a Decisão do Frigobar -->
        ${renderPolyline([
          { x: 210, y: 603 },
          { x: 210, y: 635 },
          { x: 350, y: 635 },
          { x: 350, y: 570 },
          { x: 471, y: 570 }
        ], "serviços quitados", { lx: 280, ly: 625 })}

        <!-- Ramo Direito do Frigobar: Houve consumo de frigobar -->
        ${renderPolyline([
          { x: 489, y: 570 },
          { x: 730, y: 570 }
        ], "[houve consumo de frigobar]", { lx: 615, ly: 560 })}

        ${renderState({
          x: 730, y: 545, w: 220, h: 48,
          title: "QUITANDO CONSUMO FRIGOBAR",
          lines: ["entry / COBRAR ITENS CONSUMIDOS"]
        })}

        <!-- Do Frigobar para Pagamento Finalizado -->
        ${renderPolyline([
          { x: 840, y: 593 },
          { x: 840, y: 641 },
          { x: 561, y: 641 }
        ])}

        <!-- Se não houver consumo de frigobar -->
        ${renderLine(480, 579, 480, 625, "[sem consumo frigobar]", { lx: 410, ly: 605 })}

        <!-- Estado: CHECK-OUT CONCLUÍDO -->
        ${renderState({
          x: 399, y: 625, w: 162, h: 32,
          title: "CHECK-OUT FINALIZADO",
          lines: []
        })}

        <!-- Seta direta para baixo para Final (sem sobreposição) -->
        ${renderLine(480, 657, 480, 695)}
        ${renderFinal(480, 705)}
      `;
    }
  },

  11: {
    id: 11,
    title: "11. Jogo Antigo: PAC-MAN (Surpreenda o Professor!)",
    shortTitle: "11: Pac-Man (Extra)",
    diagramName: "Statemachine PacMan_Game_Flow",
    diagramType: "stm",
    width: 980,
    height: 700,
    description: `Exercício 11 (EXTRA e Individual) - Pac-Man (Arcade Clássico de 1980):
Máquina de estados autêntica do clássico dos arcades:
• Attract Mode / Demonstração (aguardando moeda / start)
• Ready! (posicionamento dos personagens)
• Estado Composto 'IN-GAME (GAMEPLAY)':
  - Perseguição Normal (Chase / Scatter)
  - Modo Frightened (ao comer Power Pellet: fantasmas azuis e vulneráveis)
  - Fantasma Comido (olhos retornam à base)
  - Perda de Vida (animação clássica de morte)
• Avaliação de vidas (se vidas > 0, volta ao Ready!; se vidas = 0, Game Over).
• Labirinto concluído ao comer as 244 pastilhas (avança para próximo nível).
• Registro de recorde (High Score) para os melhores jogadores.`,
    render: function(w, h) {
      return `
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial -->
        ${renderInitial(60, 65)}
        ${renderLine(68, 65, 120, 65)}

        <!-- Estado: ATTRACT MODE -->
        ${renderState({
          x: 120, y: 40, w: 220, h: 52,
          title: "ATTRACT MODE (DEMONSTRAÇÃO)",
          lines: [
            "entry / EXIBIR TELA DE TÍTULO",
            "do / EXECUTAR ANIMAÇÃO DEMO"
          ]
        })}

        <!-- Inserir Moeda / Start -> Ready (espaço amplo de 180px) -->
        ${renderLine(340, 65, 520, 65, "inserir moeda / start", { lx: 430, ly: 55 })}

        <!-- Estado: READY -->
        ${renderState({
          x: 520, y: 40, w: 220, h: 52,
          title: "READY! (PREPARANDO FASE)",
          lines: [
            "entry / TOCAR JINGLE DE ABERTURA",
            "entry / POSICIONAR PERSONAGENS"
          ]
        })}

        <!-- Seta Ready -> In-Game -->
        ${renderLine(630, 92, 630, 130, "jingle finalizado", { lx: 680, ly: 112 })}

        <!-- Estado Composto: IN-GAME (GAMEPLAY) -->
        ${renderComposite(70, 130, 840, 370, "IN-GAME (LOOP DE JOGABILIDADE)")}

        <!-- Inicial interno -->
        ${renderInitial(130, 235)}
        ${renderLine(138, 235, 190, 235)}

        <!-- Sub-Estado: MODO NORMAL (CHASE / SCATTER) -->
        ${renderState({
          x: 190, y: 205, w: 250, h: 60,
          title: "CHASE / SCATTER (PERSEGUIÇÃO)",
          lines: [
            "do / FANTASMAS PERSEGUEM PAC-MAN",
            "do / PAC-MAN COME PASTILHAS NORMAIS"
          ]
        })}

        <!-- Transição Comeu Power Pellet -> Frightened Mode -->
        ${renderLine(440, 235, 540, 235, "comeu Power Pellet", { lx: 490, ly: 225 })}

        <!-- Sub-Estado: MODO FRIGHTENED (FANTASMAS AZUIS) -->
        ${renderState({
          x: 540, y: 205, w: 260, h: 60,
          title: "FRIGHTENED (FANTASMAS AZUIS)",
          lines: [
            "entry / TOCAR SIRENE DE VULNERABILIDADE",
            "do / FANTASMAS FICAM AZUIS E FOGEM"
          ]
        })}

        <!-- Fantasma Comido -> Olhos voltam à base -->
        ${renderPolyline([
          { x: 670, y: 265 },
          { x: 670, y: 310 },
          { x: 590, y: 310 },
          { x: 590, y: 265 }
        ], "comeu fantasma / olhos voltam à base", { lx: 630, ly: 325 })}

        <!-- Retorno de Frightened para Normal após tempo (rota limpa entre header e subestados) -->
        ${renderPolyline([
          { x: 640, y: 205 },
          { x: 640, y: 178 },
          { x: 320, y: 178 },
          { x: 320, y: 205 }
        ], "tempo esgotado (fantasmas voltam ao normal)", { lx: 480, ly: 170 })}

        <!-- Colisão com Fantasma -> Vida Perdida -->
        ${renderPolyline([
          { x: 310, y: 265 },
          { x: 310, y: 395 },
          { x: 405, y: 395 }
        ], "colisão com fantasma não azul", { lx: 350, ly: 355 })}

        <!-- Sub-Estado: VIDA PERDIDA -->
        ${renderState({
          x: 405, y: 370, w: 250, h: 52,
          title: "VIDA PERDIDA",
          lines: [
            "entry / ANIMAÇÃO DE MORTE DO PAC-MAN",
            "entry / SUBTRAIR 1 VIDA DO JOGADOR"
          ]
        })}

        <!-- Todas as 244 pastilhas comidas -> Fase Concluída (rota pelo espaço aberto central) -->
        ${renderPolyline([
          { x: 380, y: 265 },
          { x: 380, y: 335 },
          { x: 785, y: 335 },
          { x: 785, y: 370 }
        ], "244 pastilhas comidas", { lx: 720, ly: 325 })}

        <!-- Sub-Estado: FASE CONCLUÍDA -->
        ${renderState({
          x: 670, y: 370, w: 230, h: 52,
          title: "FASE CONCLUÍDA",
          lines: [
            "entry / PISCAR LABIRINTO",
            "entry / TOCAR MÚSICA DE INTERLÚDIO"
          ]
        })}

        <!-- Transição Fase Concluída de volta para Ready -->
        ${renderPolyline([
          { x: 785, y: 370 },
          { x: 785, y: 50 },
          { x: 740, y: 50 }
        ], "próximo nível", { lx: 795, ly: 85 })}

        <!-- Seta saindo de Vida Perdida para Decisão de Vidas -->
        ${renderLine(530, 422, 530, 520)}
        ${renderDecision(530, 530, 18)}

        <!-- Vidas Restantes -> Retorna ao Ready -->
        ${renderPolyline([
          { x: 521, y: 530 },
          { x: 25, y: 530 },
          { x: 25, y: 50 },
          { x: 520, y: 50 }
        ], "[vidas restantes > 0]", { lx: 200, ly: 520 })}

        <!-- Sem Vidas -> Game Over -->
        ${renderLine(530, 539, 530, 600, "[vidas = 0]", { lx: 570, ly: 570 })}

        <!-- Estado: GAME OVER -->
        ${renderState({
          x: 483, y: 600, w: 94, h: 32,
          title: "GAME OVER",
          lines: []
        })}

        <!-- Seta Game Over -> Decisão High Score -->
        ${renderLine(577, 616, 680, 616)}
        ${renderDecision(690, 616, 16)}

        <!-- Novo Recorde -> Inserir Iniciais -->
        ${renderPolyline([
          { x: 690, y: 608 },
          { x: 690, y: 555 },
          { x: 770, y: 555 }
        ], "[novo recorde]", { lx: 700, ly: 550 })}

        ${renderState({
          x: 770, y: 540, w: 144, h: 32,
          title: "REGISTRAR RECORD",
          lines: []
        })}

        <!-- Sem recorde -> Final -->
        ${renderLine(698, 616, 780, 616, "[sem recorde]", { lx: 740, ly: 610 })}
        ${renderFinal(790, 616)}
      `;
    }
  },

  1: {
    id: 1,
    title: "1. Ciclo de Vida do Pedido (E-Commerce)",
    shortTitle: "1: E-Commerce",
    diagramName: "Statemachine Diagram0",
    diagramType: "stm",
    width: 980,
    height: 720,
    description: `Exercício 1 - Ciclo de Vida do Pedido (E-Commerce):
• Diagrama de Máquina de Estados idêntico ao modelado no Astah UML.
• Fluxo Macro: Inicial -> AGUARDANDO PAGAMENTO -> PREPARAÇÃO E DESPACHO -> ENTREGA EM ANDAMENTO -> Final.
• Estado Composto: PREPARAÇÃO E DESPACHO com fluxo interno detalhado (SEPARANDO ITENS -> GERANDO ETIQUETA -> AGUARDANDO DESPACHO -> ENTREGA EM ANDAMENTO).`,
    render: function(w, h) {
      return `
        <!-- Moldura externa e aba oficial do Astah -->
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- === PARTE SUPERIOR: FLUXO MACRO === -->
        ${renderInitial(140, 95)}
        ${renderLine(148, 95, 180, 95)}

        ${renderState({
          x: 180, y: 72, w: 175, h: 46,
          title: "AGUARDANDO PAGAMENTO",
          lines: ["entry / NOTIFICAR CLIENTE"]
        })}

        ${renderLine(355, 95, 495, 95, "PRODUTO EM ESTOQUE", { lx: 425, ly: 115 })}

        ${renderState({
          x: 495, y: 80, w: 180, h: 30,
          title: "PREPARAÇÃO E DESPACHO",
          lines: []
        })}

        ${renderLine(675, 95, 740, 95, "PEDIDO EM DESPACHO", { lx: 708, ly: 125 })}

        ${renderState({
          x: 740, y: 72, w: 230, h: 46,
          title: "ENTREGA EM ANDAMENTO",
          lines: ["entry / NOTIFICAR TRANSPORTADORAS"]
        })}

        ${renderLine(855, 118, 835, 205, "PRODUTO ENTREGUE", { lx: 900, ly: 165 })}
        ${renderFinal(835, 215)}

        <!-- === PARTE INFERIOR: ESTADO COMPOSTO (PREPARAÇÃO E DESPACHO) === -->
        ${renderComposite(65, 270, 840, 420, "PREPARAÇÃO E DESPACHO")}

        ${renderInitial(170, 325)}
        ${renderLine(172, 333, 190, 420)}

        ${renderState({
          x: 85, y: 420, w: 210, h: 54,
          title: "SEPARANDO ITENS",
          lines: [
            "entry / SEPARAR ITENS DO PEDIDO",
            "do / ATUALIZAR STATUS DO PEDIDO"
          ]
        })}

        ${renderLine(295, 435, 350, 355, "TUDO SEPARADO", { lx: 335, ly: 440 })}

        ${renderState({
          x: 350, y: 325, w: 200, h: 54,
          title: "GERANDO ETIQUETA",
          lines: [
            "entry / CRIAR ETIQUETA DE ENVIO",
            "do / ATUALIZAR DESPACHO"
          ]
        })}

        ${renderLine(550, 355, 670, 365, "ETIQUETA CRADA", { lx: 610, ly: 410 })}

        ${renderState({
          x: 670, y: 345, w: 210, h: 54,
          title: "AGUARDANDO DESPACHO",
          lines: [
            "entry / aguardar atribuição da entrega",
            "do / aguardar atribuição da entrega"
          ]
        })}

        ${renderLine(775, 399, 775, 495, "PEDIDO EM DESPACHO", { lx: 720, ly: 450 })}

        ${renderState({
          x: 668, y: 495, w: 225, h: 46,
          title: "ENTREGA EM ANDAMENTO",
          lines: ["entry / NOTIFICAR TRANSPORTADORA"]
        })}
      `;
    }
  },

  2: {
    id: 2,
    title: "2. Agendamento de Compromissos",
    shortTitle: "2: Agendamento",
    diagramName: "Statemachine Diagram1",
    diagramType: "stm",
    width: 960,
    height: 750,
    description: `Exercício 2 - Agendamento de Compromissos:
• Diagrama de Máquina de Estados idêntico ao print do Astah UML.
• Sequência central: Inicial -> Solicitar novo agendamento -> Verificar disponibilidade da agenda -> Composto 'VERIFICAÇÃO DE CALENDARIO' -> Nó de Decisão.
• Ramo Esquerdo (DATA DISPONIVEL): Informar que a agenda está disponível -> Adicionar o compromisso -> Registrar o novo agendamento -> Final.
• Ramo Direito (DATA NÃO DISPONIVEL): Informar que não é possível realizar o agendamento -> Final.`,
    render: function(w, h) {
      return `
        <!-- Moldura externa e aba oficial do Astah -->
        ${renderOuterFrame(w, h, "stm", this.diagramName)}

        <!-- Inicial no topo -->
        ${renderInitial(480, 45)}
        ${renderLine(480, 52, 480, 85)}

        <!-- 1. Solicitar novo agendamento -->
        ${renderState({
          x: 403, y: 85, w: 154, h: 34,
          title: "Solicitar novo agendamento",
          lines: []
        })}

        ${renderLine(480, 119, 480, 150)}

        <!-- 2. Verificar disponibilidade da agenda -->
        ${renderState({
          x: 387, y: 150, w: 187, h: 34,
          title: "Verificar disponibilidade da agenda",
          lines: []
        })}

        ${renderLine(480, 184, 480, 225)}

        <!-- 3. Composto: VERIFICAÇÃO DE CALENDARIO -->
        ${renderComposite(320, 225, 320, 205, "VERIFICAÇÃO DE CALENDARIO")}

        ${renderState({
          x: 399, y: 265, w: 162, h: 34,
          title: "CONSULTAR CALENDARIO",
          lines: []
        })}

        ${renderLine(480, 299, 480, 345)}

        ${renderState({
          x: 380, y: 345, w: 201, h: 34,
          title: "VERIFICAR HORARIO DISPONIVEL",
          lines: []
        })}

        <!-- Seta saindo do composto para o nó de decisão -->
        ${renderLine(480, 430, 480, 490)}
        ${renderDecision(480, 500, 18)}

        <!-- === RAMO DIREITO: DATA NÃO DISPONIVEL === -->
        ${renderLine(489, 500, 640, 500, "DATA NÃO DISPONIVEL", { lx: 565, ly: 518 })}

        ${renderState({
          x: 640, y: 483, w: 275, h: 34,
          title: "Informar que não é possível realizar o agendamento",
          lines: []
        })}

        ${renderLine(710, 517, 570, 642)}
        ${renderFinal(562, 650)}

        <!-- === RAMO ESQUERDO: DATA DISPONIVEL === -->
        ${renderLine(471, 500, 273, 545, "DATA DISPONIVEL", { lx: 370, ly: 515 })}

        ${renderState({
          x: 67, y: 535, w: 206, h: 34,
          title: "Informar que a agenda está disponível",
          lines: []
        })}

        ${renderLine(170, 569, 170, 605)}

        ${renderState({
          x: 98, y: 605, w: 144, h: 34,
          title: "Adicionar o compromisso",
          lines: []
        })}

        ${renderLine(170, 639, 170, 675)}

        ${renderState({
          x: 85, y: 675, w: 170, h: 34,
          title: "Registrar o novo agendamento",
          lines: []
        })}

        ${renderLine(255, 692, 440, 655)}
        ${renderFinal(448, 650)}
      `;
    }
  }
};

/* =========================================================================
   AUTHENTIC ASTAH RENDERING PRIMITIVES (EXACT ASTAH REPLICA)
   ========================================================================= */

/**
 * Astah Outer Frame Border + Top-Left Tab (Authentic 45° Corner Bevel)
 */
function renderOuterFrame(width, height, type = "stm", name = "Statemachine Diagram") {
  const tabWidth = Math.max(195, Math.round((name.length + 5) * 7.2 + 20));
  const tabHeight = 22;
  return `
    <!-- Astah Outer Diagram Frame (1px solid black) -->
    <rect x="2" y="2" width="${width - 4}" height="${height - 4}" 
          fill="none" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />

    <!-- Astah Top-Left Header Tab with Authentic 45° Beveled Corner -->
    <g class="astah-tab-svg" onclick="editDiagramName()" style="cursor: pointer;" title="Clique para renomear este diagrama">
      <polygon points="2,2 ${tabWidth - 10},2 ${tabWidth},11 ${tabWidth},${tabHeight} 2,${tabHeight}" 
               fill="#ffffff" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />
      <text x="7" y="16" font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000">
        <tspan font-weight="bold">${type} </tspan>${escapeXml(name)}
      </text>
    </g>
  `;
}

/**
 * Astah State Box:
 * - Signature pastel yellow fill (#ffffcc), 1px solid black border, rx=5
 * - Horizontal compartment divider line at y + 20 always present
 * - Title centered at y + 14 in regular 11px Arial (never bold)
 * - Internal actions (entry/do/exit) left-aligned with clean 6px margin
 */
function renderState({ x, y, w, h, title, lines = [] }) {
  const headerHeight = 20;
  const hasLines = Array.isArray(lines) && lines.length > 0;
  const lineHeight = 14;
  const contentHeight = hasLines ? (headerHeight + 6 + (lines.length * lineHeight) + 6) : (h || 30);
  const boxH = Math.max(contentHeight, h || contentHeight);

  let actionMarkup = "";
  let dividerLine = "";
  let titleY = y + 14;

  if (hasLines) {
    dividerLine = `<line x1="${x}" y1="${y + headerHeight}" x2="${x + w}" y2="${y + headerHeight}" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />`;
    const textX = x + 8;
    const startY = y + headerHeight + 13;
    actionMarkup = lines.map((line, idx) => {
      return `<text x="${textX}" y="${startY + (idx * lineHeight)}" font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000">${escapeXml(line)}</text>`;
    }).join("");
  } else {
    // In authentic Astah UML, states without internal actions have NO divider line
    // and the title is centered both horizontally and vertically
    titleY = y + Math.round(boxH / 2) + 4;
  }

  return `
    <g class="astah-state">
      <rect x="${x}" y="${y}" width="${w}" height="${boxH}" rx="5" ry="5"
            fill="#ffffcc" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />
      ${dividerLine}
      <text x="${x + Math.round(w / 2)}" y="${titleY}" 
            font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000" text-anchor="middle">
        ${escapeXml(title)}
      </text>
      ${actionMarkup}
    </g>
  `;
}

/**
 * Astah Composite State:
 * - Large #ffffcc rounded rect (rx=8), 1px solid black border
 * - Divider line under header at y + 22
 * - Title centered at top
 */
function renderComposite(x, y, w, h, title) {
  const headerHeight = 22;
  return `
    <g class="astah-composite">
      <rect x="${x}" y="${y}" width="${w}" height="${h}" rx="8" ry="8"
            fill="#ffffcc" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />
      <line x1="${x}" y1="${y + headerHeight}" x2="${x + w}" y2="${y + headerHeight}" 
            stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />
      <text x="${x + Math.round(w / 2)}" y="${y + 15}" 
            font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000" text-anchor="middle">
        ${escapeXml(title)}
      </text>
    </g>
  `;
}

/**
 * Initial Node: Solid black circle
 */
function renderInitial(cx, cy, r = 7) {
  return `<circle cx="${cx}" cy="${cy}" r="${r}" fill="#000000" stroke="#000000" stroke-width="1.0" />`;
}

/**
 * Final Node: Outer white circle with 1px black stroke, inner solid black circle
 */
function renderFinal(cx, cy, r = 9) {
  return `
    <g class="astah-final">
      <circle cx="${cx}" cy="${cy}" r="${r}" fill="#ffffff" stroke="#000000" stroke-width="1.0" />
      <circle cx="${cx}" cy="${cy}" r="${r - 4}" fill="#000000" stroke="#000000" stroke-width="1.0" />
    </g>
  `;
}

/**
 * Decision Pseudostate: Diamond (#ffffcc) with 1px solid black stroke
 */
function renderDecision(cx, cy, size = 16) {
  const half = Math.round(size / 2);
  const points = `${cx},${cy - half} ${cx + half},${cy} ${cx},${cy + half} ${cx - half},${cy}`;
  return `<polygon points="${points}" fill="#ffffcc" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" />`;
}

/**
 * History Pseudostate: Circle with 'H'
 */
function renderHistory(cx, cy, text = "H", r = 10) {
  return `
    <g class="astah-history">
      <circle cx="${cx}" cy="${cy}" r="${r}" fill="#ffffff" stroke="#000000" stroke-width="1.0" />
      <text x="${cx}" y="${cy + 4}" font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000" text-anchor="middle">${text}</text>
    </g>
  `;
}

/**
 * Astah Direct Straight Line with 1px Pure Solid Black Open Chevron Arrowhead
 */
function renderLine(x1, y1, x2, y2, label = "", pos = null) {
  let labelText = "";
  if (label && label.trim() !== "") {
    const lx = pos ? pos.lx : Math.round((x1 + x2) / 2);
    const ly = pos ? pos.ly : Math.round((y1 + y2) / 2) - 4;
    labelText = `<text class="transition-label" x="${lx}" y="${ly}" font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000" text-anchor="middle">${escapeXml(label)}</text>`;
  }
  return `
    <g class="astah-transition">
      <line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" 
            stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" marker-end="url(#astah-arrow)" />
      ${labelText}
    </g>
  `;
}

/**
 * Astah Orthogonal Polyline with 1px Pure Solid Black Open Chevron Arrowhead
 */
function renderPolyline(points, label = "", pos = null) {
  const ptsString = points.map(p => `${p.x},${p.y}`).join(" ");
  let labelText = "";
  if (label && label.trim() !== "") {
    const midIdx = Math.floor(points.length / 2);
    const lx = pos ? pos.lx : points[midIdx].x;
    const ly = pos ? pos.ly : points[midIdx].y - 4;
    labelText = `<text class="transition-label" x="${lx}" y="${ly}" font-family="Arial, 'Segoe UI', sans-serif" font-size="11" fill="#000000" text-anchor="middle">${escapeXml(label)}</text>`;
  }
  return `
    <g class="astah-transition">
      <polyline points="${ptsString}" fill="none" stroke="#000000" stroke-width="1.0" shape-rendering="crispEdges" marker-end="url(#astah-arrow)" />
      ${labelText}
    </g>
  `;
}

function escapeXml(unsafe) {
  if (!unsafe) return "";
  return unsafe.replace(/[<>&'"]/g, (c) => {
    switch (c) {
      case '<': return '&lt;';
      case '>': return '&gt;';
      case '&': return '&amp;';
      case '\'': return '&apos;';
      case '"': return '&quot;';
    }
  });
}

/* =========================================================================
   APPLICATION CONTROLLER
   ========================================================================= */

// Start directly with Question 3 (since user completed 1 and 2)
let currentQId = 3;
let zoomScale = 1.0;
let isPrintMode = false;
let areLabelsHidden = false;

document.addEventListener("DOMContentLoaded", () => {
  initQuestionNav();
  loadQuestion(currentQId);
  setupEvents();
});

function initQuestionNav() {
  const nav = document.getElementById("questionNav");
  nav.innerHTML = "";
  
  // Show 3 to 11 first (active work), followed by 1 and 2 (completed by user)
  const order = [3, 4, 5, 6, 7, 8, 9, 10, 11, 1, 2];
  
  order.forEach(qId => {
    const d = DIAGRAMS[qId];
    if (!d) return;

    const btn = document.createElement("button");
    const isDone = (d.id === 1 || d.id === 2);
    btn.className = `q-tab ${d.id === currentQId ? 'active' : ''} ${isDone ? 'done' : ''}`;
    btn.innerHTML = `<span class="badge">#${d.id}</span> ${escapeXml(d.shortTitle.split(':')[1] || d.shortTitle)}`;
    btn.onclick = () => loadQuestion(d.id);
    nav.appendChild(btn);
  });
}

function loadQuestion(id) {
  currentQId = id;
  const d = DIAGRAMS[id];
  if (!d) return;

  // Update tabs
  document.querySelectorAll(".q-tab").forEach((tab) => {
    const badgeText = tab.querySelector(".badge") ? tab.querySelector(".badge").innerText : "";
    const tabNum = parseInt(badgeText.replace("#", ""));
    tab.classList.toggle("active", tabNum === id);
  });

  const container = document.getElementById("astahSheet");
  container.style.width = `${d.width}px`;
  container.style.height = `${d.height}px`;

  // Astah Open Chevron Arrowhead (sharp open black arrow of Astah, crisp 1.0px stroke)
  const svgContent = `
    <svg id="diagramSvg" class="diagram-svg" width="${d.width}" height="${d.height}" viewBox="0 0 ${d.width} ${d.height}" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <style>
          line, polyline, path, rect, polygon {
            stroke: #000000 !important;
            stroke-width: 1px !important;
            shape-rendering: crispEdges !important;
          }
          #astah-arrow path, #astah-arrow polyline {
            stroke: #000000 !important;
            stroke-width: 1px !important;
            fill: none !important;
            shape-rendering: crispEdges !important;
          }
          text {
            font-family: Arial, "Segoe UI", sans-serif;
            font-size: 11px;
            font-weight: normal;
            fill: #000000;
          }
        </style>
        <marker id="astah-arrow" markerWidth="10" markerHeight="8" refX="9" refY="4" orient="auto" markerUnits="userSpaceOnUse">
          <path d="M 1,1 L 9,4 L 1,7" fill="none" stroke="#000000" stroke-width="1.0" stroke-linecap="round" stroke-linejoin="miter" shape-rendering="crispEdges" />
        </marker>
      </defs>

      <!-- Astah Plain White Background -->
      <rect width="100%" height="100%" fill="#ffffff" />

      <!-- Diagram Elements & Outer Frame -->
      <g id="diagramBody">
        ${d.render(d.width, d.height)}
      </g>
    </svg>
  `;

  container.innerHTML = svgContent;

  // Update Drawer
  document.getElementById("drawerTitle").innerText = d.title;
  document.getElementById("enunciadoText").innerText = d.description;

  const respostaCard = document.getElementById("respostaCard");
  const respostaSection = document.getElementById("respostaSection");
  
  if (id === 4) {
    respostaSection.style.display = "block";
    respostaCard.innerHTML = `
      <strong>Descrição do Fluxo de Estados (Questão 4):</strong><br><br>
      • <strong>Estado Inicial</strong>: O sistema inicia a compra ao receber o evento de atendimento, transicionando para o estado <em>Venda Aberta</em>.<br>
      • <strong>Inclusão de Itens</strong>: No estado <em>Venda Aberta</em>, o atendente inclui produtos por meio de um loop/auto-transição (<code>incluir item / somar ao subtotal</code>), mantendo o carrinho atualizado.<br>
      • <strong>Finalizar Compra</strong>: Ao acionar o evento de finalização, o sistema transiciona para o estado <em>Escolhendo Forma de Pagamento</em>.<br>
      • <strong>Ramificação de Pagamentos</strong>: Através de um nó de escolha (decisão), o atendente opta por:<br>
        <ul>
          <li><em>Boleto</em>: Transiciona para <em>Pagamento em Boleto</em>, gerando código de barras e aguardando compensação bancária.</li>
          <li><em>Cartão</em>: Transiciona para <em>Pagamento em Cartão</em>, enviando à maquininha e aguardando a autorização de crédito/débito.</li>
          <li><em>Dinheiro</em>: Transiciona para <em>Pagamento em Dinheiro</em>, calculando o troco a ser entregue.</li>
        </ul>
      • <strong>Confirmação e Encerramento</strong>: As três ramificações convergem para <em>Pagamento Confirmado</em>, onde a nota fiscal e o comprovante são emitidos, finalizando formalmente o processo no estado final.
    `;
  } else if (id === 6) {
    respostaSection.style.display = "block";
    respostaCard.innerHTML = `
      <strong>Análise da Máquina de Estados do ATM (Questão 6):</strong><br><br>
      • <strong>Hierarquia dos Estados</strong>: O sistema possui estados macro operacionais (<em>Inicialização</em>, <em>Ocioso</em>, <em>Indisponível</em> e <em>Manutenção</em>) e um estado composto central (<em>Atendimento ao Cliente</em>). Dentro deste composto, ocorrem sequencialmente as etapas de <em>Autenticação</em> (senha/biometria), <em>Seleção da Operação</em> e <em>Execução da Transação</em>.<br><br>
      • <strong>Comportamento diante de Falhas</strong>: Falhas técnicas críticas ou término de cédulas/papel disparam transições imediatas que levam o terminal para o estado <em>Indisponível</em>, interrompendo atendimentos para proteger os fundos e dados do cliente.<br><br>
      • <strong>Diferença entre Manutenção e Indisponibilidade</strong>:
        <ul>
          <li><em>Indisponibilidade</em>: Estado de proteção onde o equipamento está fora de serviço para os usuários e notifica a central de monitoramento.</li>
          <li><em>Manutenção</em>: Estado ativo em que um técnico autenticado realiza abertura física do terminal, reposição de insumos e testes de diagnóstico antes de emitir o comando de reset para nova inicialização.</li>
        </ul>
      • <strong>Ações de Entrada e Saída</strong>: As ações de <em>entry</em> preparam o ambiente seguro (ex: acionar leitores biométricos, exibir avisos ao usuário) e as ações de <em>exit</em> asseguram o encerramento seguro (ejeção física do cartão e gravação de logs de auditoria).
    `;
  } else {
    respostaSection.style.display = "none";
  }
}

function setupEvents() {
  document.getElementById("btnZoomIn").onclick = () => updateZoom(0.15);
  document.getElementById("btnZoomOut").onclick = () => updateZoom(-0.15);
  document.getElementById("btnZoomReset").onclick = () => resetZoom();

  document.getElementById("btnPrintMode").onclick = togglePrintMode;
  document.getElementById("btnExitPrint").onclick = togglePrintMode;

  const btnToggleLabels = document.getElementById("btnToggleLabels");
  if (btnToggleLabels) {
    btnToggleLabels.onclick = toggleLabels;
  }

  document.getElementById("btnDownloadPng").onclick = downloadAsPng;
  document.getElementById("btnCopyImage").onclick = copyToClipboard;

  document.getElementById("btnToggleDrawer").onclick = toggleDrawer;
  document.getElementById("btnCloseDrawer").onclick = toggleDrawer;

  window.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && isPrintMode) {
      togglePrintMode();
    }
  });
}

function toggleLabels() {
  areLabelsHidden = !areLabelsHidden;
  document.body.classList.toggle("hide-labels", areLabelsHidden);
  const btn = document.getElementById("btnToggleLabels");
  if (btn) {
    btn.innerText = areLabelsHidden ? "🔤 Mostrar Textos das Linhas" : "🔤 Ocultar Textos das Linhas";
  }
  showToast(areLabelsHidden ? "Textos entre os retângulos ocultados!" : "Textos entre os retângulos visíveis!");
}

function updateZoom(delta) {
  zoomScale = Math.max(0.4, Math.min(2.5, zoomScale + delta));
  const sheet = document.getElementById("astahSheet");
  sheet.style.transform = `scale(${zoomScale})`;
  document.getElementById("zoomText").innerText = `${Math.round(zoomScale * 100)}%`;
}

function resetZoom() {
  zoomScale = 1.0;
  const sheet = document.getElementById("astahSheet");
  sheet.style.transform = `scale(1)`;
  document.getElementById("zoomText").innerText = `100%`;
}

function togglePrintMode() {
  isPrintMode = !isPrintMode;
  document.body.classList.toggle("print-mode", isPrintMode);
  
  if (isPrintMode) {
    resetZoom();
    showToast("Modo Print ativado! Pressione ESC para voltar.", false);
  }
}

function toggleDrawer() {
  const drawer = document.getElementById("infoDrawer");
  drawer.classList.toggle("collapsed");
}

function editDiagramName() {
  const d = DIAGRAMS[currentQId];
  const newName = prompt("Alterar nome do diagrama na aba do Astah:", d.diagramName);
  if (newName !== null && newName.trim() !== "") {
    d.diagramName = newName.trim();
    loadQuestion(currentQId);
    showToast("Nome do diagrama atualizado!");
  }
}

async function generateCanvasFromSvg(scaleFactor = 2.5) {
  const svg = document.getElementById("diagramSvg");
  if (!svg) return null;

  const width = parseFloat(svg.getAttribute("width"));
  const height = parseFloat(svg.getAttribute("height"));

  const serializer = new XMLSerializer();
  const svgString = serializer.serializeToString(svg);
  const svgBlob = new Blob([svgString], { type: "image/svg+xml;charset=utf-8" });
  const URL = window.URL || window.webkitURL || window;
  const blobURL = URL.createObjectURL(svgBlob);

  const canvas = document.createElement("canvas");
  canvas.width = width * scaleFactor;
  canvas.height = height * scaleFactor;
  const ctx = canvas.getContext("2d");

  // Pure white canvas
  ctx.fillStyle = "#ffffff";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  return new Promise((resolve, reject) => {
    const img = new Image();
    img.onload = () => {
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      URL.revokeObjectURL(blobURL);
      resolve(canvas);
    };
    img.onerror = (e) => {
      URL.revokeObjectURL(blobURL);
      reject(e);
    };
    img.src = blobURL;
  });
}

async function downloadAsPng() {
  try {
    showToast("Gerando PNG em alta resolução...");
    const canvas = await generateCanvasFromSvg(2.5);
    if (!canvas) return;

    const d = DIAGRAMS[currentQId];
    const link = document.createElement("a");
    link.download = `Astah_Exercicio_${d.id}_${d.diagramName}.png`;
    link.href = canvas.toDataURL("image/png");
    link.click();
    showToast("Download da imagem PNG concluído com sucesso!");
  } catch (err) {
    console.error(err);
    showToast("Erro ao gerar imagem. Use o Modo Print para capturar a tela.", true);
  }
}

async function copyToClipboard() {
  try {
    showToast("Copiando diagrama para a área de transferência...");
    const canvas = await generateCanvasFromSvg(2);
    if (!canvas) return;

    canvas.toBlob(async (blob) => {
      if (!blob) {
        showToast("Não foi possível gerar blob da imagem", true);
        return;
      }
      try {
        await navigator.clipboard.write([
          new ClipboardItem({ "image/png": blob })
        ]);
        showToast("Imagem copiada! Cole com Ctrl+V onde desejar.");
      } catch (clipErr) {
        console.warn("Clipboard fallback to download", clipErr);
        downloadAsPng();
      }
    }, "image/png");
  } catch (err) {
    console.error(err);
    showToast("Erro ao copiar. Use o botão Baixar PNG.", true);
  }
}

function showToast(message, isError = false) {
  let toast = document.getElementById("toast");
  if (!toast) {
    toast = document.createElement("div");
    toast.id = "toast";
    toast.className = "toast";
    document.body.appendChild(toast);
  }

  toast.innerText = message;
  toast.className = `toast show ${isError ? 'error' : ''}`;

  setTimeout(() => {
    toast.className = "toast";
  }, 3200);
}
