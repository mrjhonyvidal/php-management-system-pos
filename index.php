<?php
require_once 'controllers/template.controller.php';

// TODO refactor to use Namespace and Composer and SPL Libraries on bootstrap
require_once 'controllers/usuarios.controller.php';
require_once 'controllers/cartas.controller.php';
require_once 'controllers/descargas.controller.php';
require_once 'controllers/usuarios.controller.php';
require_once 'controllers/clientes.controller.php';

require_once 'models/cartas.model.php';
require_once 'models/descargas.model.php';
require_once 'models/usuarios.model.php';
require_once 'models/clientes.model.php';
require_once 'models/configuraciones.model.php';

require_once 'helpers/usuarios.helper.php';
require_once 'helpers/correos.helper.php';
require_once 'helpers/fechas.helper.php';
require_once 'helpers/PHPExcelReader/PHPExcelReader.php';


$template = new ControllerTemplate();
$template->ctrTemplate();
