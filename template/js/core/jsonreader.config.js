//**
var jsonWindowAdminFolders = {
	modal: true,
	resizeable: true,
	css:{
		width: 300,
		height: 400,
		//"background-color": "#FFFFFF"
		"background-color": "#C1C1C1"
	},
	id: "jsonWindowAdminFolders",
	tabs: { "�������":{
			content: "�������",
			id: "jsonWindowAdminFoldersContent"
			//jsonGrid: 
		}
	},
	buttons:{
		"wSave":function(){  
			alert("ok");
		}
	}
}

//**
var __jrc_construct_HTML__operations = "<a href=\"javascript:__jr_construct_Window_pages_tree()\">�������� ����</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">�������� ����</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">�������� ����</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">�������� ����</a><br/>";
__jrc_construct_HTML__operations += "<a href=\"javascript:\">�������� ����</a><br/>";

//**
__jrc_grid_HTML_block_visibility = {
	0:	{name: "�����������", connect: "pageType"}
}

//**
__jrc_grid_HTML_block_connection = {
	0:	{name: "���� ����������", connect: "connectionField"},
	1: {name: "��� �������� ������", connect: "pagePost"}
}

//**
__jrc_grid_HTML_block_type = {
	0:	{name: "��� �����", connect: "multiType~name"},
	1: {name: "Id �����", connect: "multiType~id"},
	2: {name: "���������� ���������", connect: "multiType~count"},
	3: {name: "���� �������", connect: "multiType~requirement"},
	4: {name: "�������� �������", connect: "multiType~requirement_value"},
	5: {name: "��� ���������", connect: "multiType~requirement_type"},
	6: {name: "�������� ���������", connect: "multiType~fromlink"},
	7: {name: "����������� �����", connect: "multiType~requirement_parent"}
}

//**
__jrc_grid_HTML_block_properties = {
	0:	{name: "��� (tag)", connect: "tagname"},
	1:	{name: "�������������", connect: "id"},
	2: {name: "����� (class)", connect: "className"},
	3: {name: "�����", connect: "content"},
	4: {
		name: "���������� � �����",
		type: "connectionField"
	},
	5: {name: "��������� (require)", connect: "pageRequire"},
	6: {name: "������������", connect: "stretch"}
}

//**
function __jrc_create_object_HTML_tabs(){
	var __jrc_object_HTML_tabs = {
		"�������":{
			content: "�������",
			id: "jsonWindowContent"
			//jsonGrid: 
		},
		"�������� �����":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_properties" },
			id: "jsonWindowProperties"
			//jsonGrid: 
		},
		"����������":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_type" },
			id: "jsonWindowType"
			//jsonGrid: 
		},
		"���������� � �����":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_connection" },
			id: "jsonWindowConnection"
			//jsonGrid: 
		},
		"�����������":{
			content: { key: "__gkv_construct_grid", value: "__jrc_grid_HTML_block_visibility" },
			id:"jsonWindowVisible",
		},
		"CSS ����������":{
			content:"CSS �����", 
			id:"jsonWindowCSSinner",
		},
		"CSS �������":{
			content:"asd", 
			id:"jsonWindowCSSouter",
		},
		"��������":{
			content:{ key: "__jr_construct_HTML", value: "__jrc_construct_HTML__operations" }, 
			id:"jsonWindowCSSouter",
		}
	}
	return __jrc_object_HTML_tabs;
}
