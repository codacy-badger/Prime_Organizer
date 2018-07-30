# Prime_Organizer [![Codacy Badge](https://api.codacy.com/project/badge/Grade/81c1582561ba413299cdf7f0ee8d5ac6)](https://www.codacy.com/project/rafinhacarneiro/Prime_Organizer/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=rafinhacarneiro/Prime_Organizer&amp;utm_campaign=Badge_Grade_Dashboard) 
App de RH da Prime Control. Feito com AppGini e customizado com PHP/HTML/JS/CSS (Bootstrap)

Customização pelos arquivos na pasta _/hooks_.

**v. 1.3**:
- Tabela _Vagas_ alterada
  - Uma vaga é atribuída à um requerimento e recebe o valor correspondente (**ex:** REQ 1-2 é a segunda vaga do Requerimento 1)
  - **Status** da vaga alterado para _Aberta/Congelada/Encerrada/Aguardando/Processo Adicional_
    - Campo **Detalhe do Status** e **Canal de Fechamento** adicionados.
      - **Detalhe do Status (VarChar(40))** - Valores: _Cancelada/Preenchida por terceiros/Preenchida pela Prime Control
    - Campo **Canal de Fechamento
      - **Canal de Fechamento (VarChar(255))** - Valores: _texto explicando como a vaga foi fechada_
  - Campo **Nome do Contratado** retirado
  - Depois de encerrada, uma vaga não pode ser editada
    - Adicionado alert de confirmação da ação
    - Somente um usuário de um grupo aprovado pode encerrar vagas (_RH_, _Vagas_ ou _Admin_)
- Adicionado botão com filtros automáticos para todos os recrutadores, com suas respectivas vagas abertas


**v. 1.2**:
- Adicionado _plugin_ de criação de filtros de pesquisa
- Adicionado filtro de pesquisa à tabela _Vagas_
- Adicionado campo obrigatório _CPF_ à tabela Colaboradores (`tb_contratacao`)
- Adicionado botão que redireciona para os indicadores do Power BI (http://indicadores.primecontrol.com.br/)
- Tabela _Requisição de Vagas_ adicionada
  - Um requerimento cria vagas na tabela Vaga
  - Vagas somente serão criadas quando o requerimento é aprovado por um usuário de um grupo aprovado (_RH_, _Vagas_ ou _Admin_). Senão, pode ser rejeitado ou permanecer pendente.
  - As vagas podem ter atributos alterados que não refletem no requerimento (**ex:** uma vaga pode ter um recrutador/alocação diferente das outras vagas)
  - O requerimento só é fechado quando é aprovado ou rejeitado. Após isso não permite alteração
    - Adicionado alert de confirmação da ação
- Adicionado query que resgata dados sobre a tabela _Requisição de Vagas_ na API da Prime Control


**v. 1.1**:
- Integração com o Mautic Open Source Marketing para envio de emails
  - Se o contato do Organizer já existe no Mautic, é atualizado, senão, é criado.
  - Adicionado botão que redireciona para a página do contato no Mautic
