# Prime_Organizer
App de RH da Prime Control. Feito com AppGini e customizado com PHP/HTML/JS/CSS (Bootstrap)

Customização pelos arquivos na pasta _/hooks_.

**Customização v2**:
- Tabela _Requerimento de Vagas_ adicionada
  - Um requerimento pode criar vagas na tabela Vaga
  - Todas as alterações em um requerimento alteram as vagas correspondentes.
  - Vagas somente serão criadas quando o requerimento é aprovado por um usuário de um grupo aprovado (_RH_, _Vagas_ ou _Admin_). Senão, pode ser rejeitado ou permanecer pendente.
  - As vagas podem ter atributos alterados que não refletem no requerimento (**ex:** uma vaga pode ter um recrutador/alocação diferente das outras vagas)
  - O requerimento só é fechado quando todas as vagas correspondentes são preenchidas ou canceladas
- Adicionado _plugin_ de criação de filtros de pesquisa
- Adicionado filtro de pesquisa à tabela _Vagas_
- Adicionado campo obrigatório e único _CPF_ à tabela Colaboradores (`tb_contratacao`)

**Customização v1**:
- Integração com o Mautic Open Source Marketing para envio de emails
