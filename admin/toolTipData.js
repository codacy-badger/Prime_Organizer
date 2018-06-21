var FiltersEnabled = 0; // if your not going to use transitions or filters in any of the tips set this to 0
var spacer="&nbsp; &nbsp; &nbsp; ";

// email notifications to admin
notifyAdminNewMembers0Tip=["", spacer+"No email notifications to admin."];
notifyAdminNewMembers1Tip=["", spacer+"Notify admin only when a new member is waiting for approval."];
notifyAdminNewMembers2Tip=["", spacer+"Notify admin for all new sign-ups."];

// visitorSignup
visitorSignup0Tip=["", spacer+"If this option is selected, visitors will not be able to join this group unless the admin manually moves them to this group from the admin area."];
visitorSignup1Tip=["", spacer+"If this option is selected, visitors can join this group but will not be able to sign in unless the admin approves them from the admin area."];
visitorSignup2Tip=["", spacer+"If this option is selected, visitors can join this group and will be able to sign in instantly with no need for admin approval."];

// tb_vaga table
tb_vaga_addTip=["",spacer+"This option allows all members of the group to add records to the 'Vagas' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_vaga_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Vagas' table."];
tb_vaga_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Vagas' table."];
tb_vaga_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Vagas' table."];
tb_vaga_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Vagas' table."];

tb_vaga_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Vagas' table."];
tb_vaga_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Vagas' table."];
tb_vaga_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Vagas' table."];
tb_vaga_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Vagas' table, regardless of their owner."];

tb_vaga_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Vagas' table."];
tb_vaga_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Vagas' table."];
tb_vaga_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Vagas' table."];
tb_vaga_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Vagas' table."];

// tb_entrevista table
tb_entrevista_addTip=["",spacer+"This option allows all members of the group to add records to the 'Atividades de R&S' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_entrevista_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Atividades de R&S' table."];
tb_entrevista_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Atividades de R&S' table."];
tb_entrevista_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Atividades de R&S' table."];
tb_entrevista_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Atividades de R&S' table."];

tb_entrevista_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Atividades de R&S' table."];
tb_entrevista_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Atividades de R&S' table."];
tb_entrevista_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Atividades de R&S' table."];
tb_entrevista_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Atividades de R&S' table, regardless of their owner."];

tb_entrevista_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Atividades de R&S' table."];
tb_entrevista_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Atividades de R&S' table."];
tb_entrevista_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Atividades de R&S' table."];
tb_entrevista_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Atividades de R&S' table."];

// tb_contratacao table
tb_contratacao_addTip=["",spacer+"This option allows all members of the group to add records to the 'Colaboradores' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_contratacao_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Colaboradores' table."];
tb_contratacao_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Colaboradores' table."];
tb_contratacao_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Colaboradores' table."];
tb_contratacao_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Colaboradores' table."];

tb_contratacao_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Colaboradores' table."];
tb_contratacao_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Colaboradores' table."];
tb_contratacao_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Colaboradores' table."];
tb_contratacao_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Colaboradores' table, regardless of their owner."];

tb_contratacao_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Colaboradores' table."];
tb_contratacao_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Colaboradores' table."];
tb_contratacao_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Colaboradores' table."];
tb_contratacao_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Colaboradores' table."];

// tb_alocacao table
tb_alocacao_addTip=["",spacer+"This option allows all members of the group to add records to the 'Aloca&#231;&#227;o' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_alocacao_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Aloca&#231;&#227;o' table."];

tb_alocacao_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Aloca&#231;&#227;o' table, regardless of their owner."];

tb_alocacao_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Aloca&#231;&#227;o' table."];
tb_alocacao_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Aloca&#231;&#227;o' table."];

// tb_recrutador table
tb_recrutador_addTip=["",spacer+"This option allows all members of the group to add records to the 'Gestores' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_recrutador_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Gestores' table."];
tb_recrutador_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Gestores' table."];
tb_recrutador_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Gestores' table."];
tb_recrutador_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Gestores' table."];

tb_recrutador_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Gestores' table."];
tb_recrutador_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Gestores' table."];
tb_recrutador_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Gestores' table."];
tb_recrutador_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Gestores' table, regardless of their owner."];

tb_recrutador_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Gestores' table."];
tb_recrutador_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Gestores' table."];
tb_recrutador_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Gestores' table."];
tb_recrutador_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Gestores' table."];

// tb_empresa table
tb_empresa_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contas' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_empresa_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contas' table."];
tb_empresa_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contas' table."];
tb_empresa_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contas' table."];
tb_empresa_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contas' table."];

tb_empresa_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contas' table."];
tb_empresa_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contas' table."];
tb_empresa_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contas' table."];
tb_empresa_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contas' table, regardless of their owner."];

tb_empresa_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contas' table."];
tb_empresa_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contas' table."];
tb_empresa_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contas' table."];
tb_empresa_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contas' table."];

// tb_prova_tipo table
tb_prova_tipo_addTip=["",spacer+"This option allows all members of the group to add records to the 'Tipos de provas' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_prova_tipo_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Tipos de provas' table."];
tb_prova_tipo_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Tipos de provas' table."];
tb_prova_tipo_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Tipos de provas' table."];
tb_prova_tipo_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Tipos de provas' table."];

tb_prova_tipo_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Tipos de provas' table."];
tb_prova_tipo_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Tipos de provas' table."];
tb_prova_tipo_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Tipos de provas' table."];
tb_prova_tipo_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Tipos de provas' table, regardless of their owner."];

tb_prova_tipo_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Tipos de provas' table."];
tb_prova_tipo_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Tipos de provas' table."];
tb_prova_tipo_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Tipos de provas' table."];
tb_prova_tipo_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Tipos de provas' table."];

// tb_contato table
tb_contato_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contato' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_contato_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contato' table."];
tb_contato_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contato' table."];
tb_contato_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contato' table."];
tb_contato_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contato' table."];

tb_contato_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contato' table."];
tb_contato_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contato' table."];
tb_contato_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contato' table."];
tb_contato_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contato' table, regardless of their owner."];

tb_contato_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contato' table."];
tb_contato_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contato' table."];
tb_contato_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contato' table."];
tb_contato_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contato' table."];

// tb_contato_tipo table
tb_contato_tipo_addTip=["",spacer+"This option allows all members of the group to add records to the 'Tipos de relacionamento' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_contato_tipo_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Tipos de relacionamento' table."];
tb_contato_tipo_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Tipos de relacionamento' table."];
tb_contato_tipo_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Tipos de relacionamento' table."];
tb_contato_tipo_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Tipos de relacionamento' table."];

tb_contato_tipo_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Tipos de relacionamento' table."];
tb_contato_tipo_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Tipos de relacionamento' table."];
tb_contato_tipo_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Tipos de relacionamento' table."];
tb_contato_tipo_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Tipos de relacionamento' table, regardless of their owner."];

tb_contato_tipo_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Tipos de relacionamento' table."];
tb_contato_tipo_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Tipos de relacionamento' table."];
tb_contato_tipo_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Tipos de relacionamento' table."];
tb_contato_tipo_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Tipos de relacionamento' table."];

// tb_oportunidade table
tb_oportunidade_addTip=["",spacer+"This option allows all members of the group to add records to the 'Oportunidades' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_oportunidade_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Oportunidades' table."];
tb_oportunidade_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Oportunidades' table."];
tb_oportunidade_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Oportunidades' table."];
tb_oportunidade_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Oportunidades' table."];

tb_oportunidade_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Oportunidades' table."];
tb_oportunidade_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Oportunidades' table."];
tb_oportunidade_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Oportunidades' table."];
tb_oportunidade_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Oportunidades' table, regardless of their owner."];

tb_oportunidade_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Oportunidades' table."];
tb_oportunidade_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Oportunidades' table."];
tb_oportunidade_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Oportunidades' table."];
tb_oportunidade_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Oportunidades' table."];

// tb_atendimento table
tb_atendimento_addTip=["",spacer+"This option allows all members of the group to add records to the 'Atendimentos' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_atendimento_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Atendimentos' table."];
tb_atendimento_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Atendimentos' table."];
tb_atendimento_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Atendimentos' table."];
tb_atendimento_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Atendimentos' table."];

tb_atendimento_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Atendimentos' table."];
tb_atendimento_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Atendimentos' table."];
tb_atendimento_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Atendimentos' table."];
tb_atendimento_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Atendimentos' table, regardless of their owner."];

tb_atendimento_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Atendimentos' table."];
tb_atendimento_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Atendimentos' table."];
tb_atendimento_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Atendimentos' table."];
tb_atendimento_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Atendimentos' table."];

// tb_oportunidade_tipo table
tb_oportunidade_tipo_addTip=["",spacer+"This option allows all members of the group to add records to the 'Tipos das oportunidades' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_oportunidade_tipo_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Tipos das oportunidades' table."];

tb_oportunidade_tipo_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Tipos das oportunidades' table, regardless of their owner."];

tb_oportunidade_tipo_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Tipos das oportunidades' table."];
tb_oportunidade_tipo_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Tipos das oportunidades' table."];

// tb_oportunidade_estagio table
tb_oportunidade_estagio_addTip=["",spacer+"This option allows all members of the group to add records to the 'Est&#225;gios de oportunidades' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_oportunidade_estagio_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Est&#225;gios de oportunidades' table."];

tb_oportunidade_estagio_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Est&#225;gios de oportunidades' table, regardless of their owner."];

tb_oportunidade_estagio_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Est&#225;gios de oportunidades' table."];
tb_oportunidade_estagio_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Est&#225;gios de oportunidades' table."];

// tb_acompanhamento table
tb_acompanhamento_addTip=["",spacer+"This option allows all members of the group to add records to the 'Acompanhamento' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_acompanhamento_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Acompanhamento' table."];
tb_acompanhamento_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Acompanhamento' table."];
tb_acompanhamento_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Acompanhamento' table."];
tb_acompanhamento_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Acompanhamento' table."];

tb_acompanhamento_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Acompanhamento' table."];
tb_acompanhamento_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Acompanhamento' table."];
tb_acompanhamento_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Acompanhamento' table."];
tb_acompanhamento_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Acompanhamento' table, regardless of their owner."];

tb_acompanhamento_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Acompanhamento' table."];
tb_acompanhamento_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Acompanhamento' table."];
tb_acompanhamento_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Acompanhamento' table."];
tb_acompanhamento_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Acompanhamento' table."];

// tb_contrato table
tb_contrato_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contratos' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_contrato_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contratos' table."];
tb_contrato_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contratos' table."];
tb_contrato_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contratos' table."];
tb_contrato_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contratos' table."];

tb_contrato_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contratos' table."];
tb_contrato_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contratos' table."];
tb_contrato_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contratos' table."];
tb_contrato_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contratos' table, regardless of their owner."];

tb_contrato_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contratos' table."];
tb_contrato_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contratos' table."];
tb_contrato_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contratos' table."];
tb_contrato_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contratos' table."];

// tb_campanha table
tb_campanha_addTip=["",spacer+"This option allows all members of the group to add records to the 'Campanha' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_campanha_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Campanha' table."];
tb_campanha_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Campanha' table."];
tb_campanha_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Campanha' table."];
tb_campanha_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Campanha' table."];

tb_campanha_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Campanha' table."];
tb_campanha_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Campanha' table."];
tb_campanha_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Campanha' table."];
tb_campanha_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Campanha' table, regardless of their owner."];

tb_campanha_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Campanha' table."];
tb_campanha_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Campanha' table."];
tb_campanha_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Campanha' table."];
tb_campanha_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Campanha' table."];

// tb_campanha_contato table
tb_campanha_contato_addTip=["",spacer+"This option allows all members of the group to add records to the 'Contatos da campanha' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_campanha_contato_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Contatos da campanha' table."];
tb_campanha_contato_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Contatos da campanha' table."];
tb_campanha_contato_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Contatos da campanha' table."];
tb_campanha_contato_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Contatos da campanha' table."];

tb_campanha_contato_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Contatos da campanha' table."];
tb_campanha_contato_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Contatos da campanha' table."];
tb_campanha_contato_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Contatos da campanha' table."];
tb_campanha_contato_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Contatos da campanha' table, regardless of their owner."];

tb_campanha_contato_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Contatos da campanha' table."];
tb_campanha_contato_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Contatos da campanha' table."];
tb_campanha_contato_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Contatos da campanha' table."];
tb_campanha_contato_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Contatos da campanha' table."];

// tb_acompanhamento_colaborador table
tb_acompanhamento_colaborador_addTip=["",spacer+"This option allows all members of the group to add records to the 'Acompanhamento individual' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_acompanhamento_colaborador_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Acompanhamento individual' table."];

tb_acompanhamento_colaborador_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Acompanhamento individual' table, regardless of their owner."];

tb_acompanhamento_colaborador_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Acompanhamento individual' table."];
tb_acompanhamento_colaborador_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Acompanhamento individual' table."];

// tb_indicador table
tb_indicador_addTip=["",spacer+"This option allows all members of the group to add records to the 'Metas e Indicadores' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_indicador_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Metas e Indicadores' table."];
tb_indicador_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Metas e Indicadores' table."];
tb_indicador_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Metas e Indicadores' table."];
tb_indicador_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Metas e Indicadores' table."];

tb_indicador_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Metas e Indicadores' table."];
tb_indicador_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Metas e Indicadores' table."];
tb_indicador_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Metas e Indicadores' table."];
tb_indicador_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Metas e Indicadores' table, regardless of their owner."];

tb_indicador_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Metas e Indicadores' table."];
tb_indicador_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Metas e Indicadores' table."];
tb_indicador_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Metas e Indicadores' table."];
tb_indicador_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Metas e Indicadores' table."];

// tb_indicador_periodo table
tb_indicador_periodo_addTip=["",spacer+"This option allows all members of the group to add records to the 'Per&#237;odos dos indicadores' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_indicador_periodo_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Per&#237;odos dos indicadores' table."];

tb_indicador_periodo_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Per&#237;odos dos indicadores' table, regardless of their owner."];

tb_indicador_periodo_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Per&#237;odos dos indicadores' table."];
tb_indicador_periodo_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Per&#237;odos dos indicadores' table."];

// tb_fatura table
tb_fatura_addTip=["",spacer+"This option allows all members of the group to add records to the 'Faturamento' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_fatura_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Faturamento' table."];
tb_fatura_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Faturamento' table."];
tb_fatura_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Faturamento' table."];
tb_fatura_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Faturamento' table."];

tb_fatura_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Faturamento' table."];
tb_fatura_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Faturamento' table."];
tb_fatura_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Faturamento' table."];
tb_fatura_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Faturamento' table, regardless of their owner."];

tb_fatura_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Faturamento' table."];
tb_fatura_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Faturamento' table."];
tb_fatura_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Faturamento' table."];
tb_fatura_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Faturamento' table."];

// tb_ajuste_colaborador table
tb_ajuste_colaborador_addTip=["",spacer+"This option allows all members of the group to add records to the 'Ajustes do Colaborador' table. A member who adds a record to the table becomes the 'owner' of that record."];

tb_ajuste_colaborador_view0Tip=["",spacer+"This option prohibits all members of the group from viewing any record in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_view1Tip=["",spacer+"This option allows each member of the group to view only his own records in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_view2Tip=["",spacer+"This option allows each member of the group to view any record owned by any member of the group in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_view3Tip=["",spacer+"This option allows each member of the group to view all records in the 'Ajustes do Colaborador' table."];

tb_ajuste_colaborador_edit0Tip=["",spacer+"This option prohibits all members of the group from modifying any record in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_edit1Tip=["",spacer+"This option allows each member of the group to edit only his own records in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_edit2Tip=["",spacer+"This option allows each member of the group to edit any record owned by any member of the group in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_edit3Tip=["",spacer+"This option allows each member of the group to edit any records in the 'Ajustes do Colaborador' table, regardless of their owner."];

tb_ajuste_colaborador_delete0Tip=["",spacer+"This option prohibits all members of the group from deleting any record in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_delete1Tip=["",spacer+"This option allows each member of the group to delete only his own records in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_delete2Tip=["",spacer+"This option allows each member of the group to delete any record owned by any member of the group in the 'Ajustes do Colaborador' table."];
tb_ajuste_colaborador_delete3Tip=["",spacer+"This option allows each member of the group to delete any records in the 'Ajustes do Colaborador' table."];

/*
	Style syntax:
	-------------
	[TitleColor,TextColor,TitleBgColor,TextBgColor,TitleBgImag,TextBgImag,TitleTextAlign,
	TextTextAlign,TitleFontFace,TextFontFace, TipPosition, StickyStyle, TitleFontSize,
	TextFontSize, Width, Height, BorderSize, PadTextArea, CoordinateX , CoordinateY,
	TransitionNumber, TransitionDuration, TransparencyLevel ,ShadowType, ShadowColor]

*/

toolTipStyle=["white","#00008B","#000099","#E6E6FA","","images/helpBg.gif","","","","\"Trebuchet MS\", sans-serif","","","","3",400,"",1,2,10,10,51,1,0,"",""];

applyCssFilter();
