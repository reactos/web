<?php
/**
*
* This program is the full and free Spanish (of Spain) phpBB 3.0 Translation.
* Copyright (c) 2007 Huan Manwe for phpbb-es.com
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along
* with this program; if not, write to the Free Software Foundation, Inc.,
* 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*
**/

/**
*
* help_faq.php [Spanish [Es]]
*
* Built with the FAQ Manager addon by EXreaction
* http://www.lithiumstudios.org/phpBB3/viewtopic.php?f=31&t=464
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

$help = array(
	array(
		0 => '--',
		1 => 'Problemas acerca de la identificación y el registro'
	),
	array(
		0 => '¿Por qué no puedo identificarme?',
		1 => 'Existen varias razones por lo cuál esto puede suceder. Primero, asegúrese de que su nombre de usuario y contraseña se encuentren escritos correctamente. Si lo están, comuníquese con La Administración para asegurarse de que no ha sido excluido. También es posible que el foro esté mal configurado por su dueño y/o tenga fallos en la programación, por lo que necesitaría ser reparado.'
	),
	array(
		0 => '¿Por qué me tengo que registrar?',
		1 => 'No está obligado a hacerlo, la decisión la toman los administradores y moderadores. En algunos casos necesitará registrarse para publicar temas y respuestas. Sin embargo, estar registrado le dará acceso a contenidos adicionales y/o ventajas que como usuario invitado no disfrutaría, como tener su imagen personalizada (avatar), mensajes privados, suscripción a grupos de usuarios, etc. Tan solo le tomará unos segundos. Es muy recomendable.'
	),
	array(
		0 => '¿Por qué mi sesión de usuario expira automáticamente?',
		1 => 'Si no activa la casilla <em>Entrar automáticamente</em> cuando ingresa al foro, sus datos se guardan en una cookie segura, que se elimina al salir de la página o al cabo de cierto tiempo. Esto previene que su cuenta pueda ser usada por otra persona. Para que el sistema le reconozca automáticamente solo marque la casilla al ingresar. No es recomendable si accede al foro desde un PC compartido, e.j. biblioteca, cyber-cafés, PC\'s de universidades, etc. Si no ve la casilla, significa que la administración del foro ha deshabilitado la opción.'
	),
	array(
		0 => '¿Cómo evito que mi nombre de usuario aparezca en las listas de usuarios identificados?',
		1 => 'Dentro del Panel de Control de Usuario, en "Preferencias de Foros", encontrará la opción <em>Ocultar mi estado de conexión</em>. Habilite la opción con <em>SI</em> y solamente será visto por administradores, moderadores y usted mismo. Será contabilizado como usuario oculto.'
	),
	array(
		0 => '¡Perdí mi contraseña!',
		1 => 'No se asuste, ¡calma! Si su contraseña no puede ser recuperada puede desactivarla o cambiarla. Visite la página de ingreso (login) y haga clic en <em>Olvidé mi contraseña</em>. Siga las instrucciones y estará identificado nuevamente en muy poco tiempo.'
	),
	array(
		0 => 'Me he registrado ¡y no me puedo identificar!',
		1 => 'Primero, verifique su nombre de usuario y contraseña. Si todo está correcto, hay dos posibles razones. Si el Sistema de Protección Infantil (APPCO) está activado y cuando se registró eligió la opción <em>Soy menor de 13 años</em> entonces tendrá que seguir algunas instrucciones que se le darán para activar la cuenta. Algunos foros disponen que las cuentas deben ser activadas, ya sea por usted mismo o por La Administración, antes de que pueda identificarse; esta información se le brindará al finalizar el proceso de registro. Si se le envió un e-mail, siga las instrucciones. Si no recibió ningún e-mail, seguramente la dirección de correo electrónico que proporcionó no es correcta o tal vez haya sido capturada por un filtro anti-spam. Si está seguro de que la dirección de e-mail que proporcionó es correcta, envíe un mensaje a La Administración.'
	),
	array(
		0 => 'Hace un tiempo me registré, ¡pero ahora no puedo conectarme!',
		1 => 'Es posible que la administración haya desactivado o borrado su cuenta por alguna razón. También, algunos foros periódicamente remueven sus usuarios que no publicaron mensajes por cierto periodo de tiempo para reducir el peso de la base de datos. Si es así, registrese de nuevo y participe de las discuciones.',
	),
	array(
		0 => '¿Qué es COPPA? (APPCO)',
		1 => 'COPPA, APPCO, o Acta de Privacidad y Protección de Niños menores de 13 años del año 1998, es una ley de los Estados Unidos, donde se solicita a los sitios de Internet, los cuales son potenciales recolectores de información, que el registro de niños sea escrito y ratificado con el consentimiento de los padres o con algún otro método de reconocimiento de guardia legal, que permita recolectar información personal identificable de un menor de edad.'
	),
	array(
		0 => '¿Por qué no puedo registrarme?',
		1 => 'Es posible que La Administración del sitio haya baneado su dirección IP o que el nombre de usuario con el que está intentando registrarse, esté deshabilitado. También puede estar deshabilitado el registro de nuevos usuarios. Póngase en contacto con La Administración del sitio.'
	),
	array(
		0 => '¿Cuál es la función de "Borrar todas las cookies del Sitio"?',
		1 => '"Borrar todas las cookies del Sitio" borra las cookies creadas por phpBB, las cuales le mantienen autorizado para acceder a determinados recursos del foro y estar identificado al mismo. También proveen funciones como leer el seguimiento de la navegación del foro por el usuario si la administración ha habilitado la opción. Si está teniendo problemas con el ingreso o salida del foro, borrar las cookies seguramente ayudará.'
	),
	array(
		0 => '--',
		1 => 'Preferencias de usuario y configuraciones'
	),
	array(
		0 => '¿Cómo se puede cambiar mi configuración?',
		1 => 'Si es un usuario registrado, todos sus datos y configuraciones están archivados en nuestra base de datos. Para modificarlos, visite el Panel de Control de Usuario; el enlace se encuentra en la parte superior de las páginas del foro. Este sistema le permitirá cambiar sus datos y preferencias.'
	),
	array(
		0 => '¡La hora en los foros no es correcta!',
		1 => 'Es posible que esté viendo la hora correspondiente a otra zona horaria. Si este es el caso, visite el Panel de Control de Usuario y defina su zona horaria de acuerdo a su ubicación, e.j. Londres, París, Nueva York, Sydney, etc. Recuerde que para cambiar la zona horaria, como las demás preferencias, debe estar registrado. Si no lo está, este es un buen momento para hacerlo.'
	),
	array(
		0 => 'Cambié la zona horaria en mi perfil, ¡pero la hora sigue siendo incorrecto!',
		1 => 'Si está seguro de que de la zona horaria es correcta al igual que el horario de verano establecido, y la hora sigue siendo incorrecta, entonces la hora almacenada en el servidor es errónea. Por favor comuníquese con La Administración para corregir el problema.'
	),
	array(
		0 => '¡Mi idioma no está en la lista!',
		1 => 'Esto se puede deber a que la administración no ha instalado el paquete de su idioma para el foro o nadie ha creado una traducción. Pregúntele al administrador si puede instalar el paquete del idioma que necesita. Si el paquete no existe, siéntase libre de hacer una traducción. Puede encontrar más información en el sitio de phpBB (ver el enlace al final de la página).'
	),
	array(
		0 => '¿Cómo se puede poner una imagen debajo de mi nombre de usuario?',
		1 => 'Hay dos imágenes que pueden aparecer debajo de su nombre de usuario cuando esté viendo los mensajes. Dependiendo de la plantilla que utilice el foro, la primera imagen está asociada a la posición (rank) del usuario, generalmente en forma de estrellas, bloques o puntos, indicando la cantidad de mensajes publicados por usted o su estatus dentro del foro. La segunda, usualmente una imagen más grande, es conocida como avatar y generalmente es única o personal para cada usuario. Es la administración quien decide si se pueden usar o no y en que tamaño y peso pueden ser publicadas. En caso de que no este disponible la opción de avatar, comuníquese con La Administración para que sea activada.'
	),
	array(
		0 => '¿Cómo se puede cambiar mi rango?',
		1 => 'Los rangos aparecen debajo del nombre de usuario e indican la cantidad de publicaciones realizadas por el usuario o la posición del mismo dentro del foro, e.j. moderadores y administradores. En general, no puede cambiar su rango directamente ya que está determinado por la administración. Por favor, no abuse de sus privilegios de publicación solo para incrementar su rango. La mayoría de los foros lo consideran "spam", no lo toleran,  y moderadores o administradores reducirán el número de publicaciones realizadas, llegando incluso a tomar medidas mas drásticas, como la expulsión del foro.'
	),
	array(
		0 => 'Cuando hago clic sobre el enlace de e-mail de un usuario, ¡me pide que me registre!',
		1 => 'Solo usuarios registrados pueden enviar e-mail a otros usuarios a través del foro, si la administración habilita la opción. Esto es para prevenir el uso malicioso del sistema de e-mail por usuarios anónimos.'
	),
	array(
		0 => '--',
		1 => 'Publicación de mensajes'
	),
	array(
		0 => '¿Cómo se puede publicar un mensaje en el foro?',
		1 => 'Para publicar un nuevo tema en el foro regístrate como miembro, haciendo clic en el enlace de registro, generalmente arriba de cada página. Seguramente necesite registrarse antes de poder publicar y responder. Abajo de cada foro encontrará una lista de acciones permitidas. Ejemplo: Puede publicar nuevos temas, Puede votar en las encuestas, etc.'
	),
	array(
		0 => '¿Cómo se puede editar o borrar un mensaje?',
		1 => 'A menos que sea administrador o moderador, solo puede borrar o editar sus propios mensajes. Para editarlos debe hacer clic en en botón <em>editar</em> (a veces esta opción solo es válida durante un cierto periodo de tiempo). Si alguien editase su tema, encontrará un pequeño texto indicando que ha sido modificado y las veces que lo ha sido. No aparece si fue un moderador o la administración quién lo editó, aunque la mayoría de las veces el editor deja su nombre de usuario y la causa de la edición. Los usuarios normales no podrán borrar sus temas después de que alguien haya respondido al mismo.'
	),
	array(
		0 => '¿Cómo se puede añadir una firma a mi mensaje?',
		1 => 'Para añadir una firma a sus mensajes debe crearla en el Panel de Control de Usuario. Una vez creada, active la opción <em>Añadir firma</em> cuando publique un mensaje. Puede asignar una firma por defecto a todos sus mensajes activando la casilla correcta en su perfil. Para dejar de añadirla en los mensajes, debe desactivar la opción <em>Añadir firma</em> dentro del perfil.'
	),
	array(
		0 => '¿Cómo creo una encuesta?',
		1 => 'Cuando inicia un nuevo tema o edita el primer mensaje del mismo, debe hacer clic en la etiqueta "Agregar Encuesta" debajo del formulario de publicación; si no la visualiza, significa que no posee los permisos apropiados para crear encuestas. Inserte un título y al menos dos opciones en el campo apropiado, asegurándose de que cada opción se encuentre en la correspondiente línea del formulario. También puede elegir el número de opciones que el usuario puede seleccionar en la etiqueta "Opciones por usuario", el tiempo límite en días para la encuesta (0 para duración infinita) y por último la opción de permitir a lo usuarios cambiar su votos.'
	),
	array(
		0 => '¿Por qué no se puede añadir más opciones a la encuesta?',
		1 => 'El límite para opciones de una encuesta está fijado por la administración. Si necesita añadir más opciones a la encuesta, comuníquese con La Administración.'
	),
	array(
		0 => '¿Cómo edito o borro una encuesta?',
		1 => 'Como en los mensajes, las encuestas solo pueden ser modificadas por su creador original, un moderador o la administración. Para editar una encuesta, hay que editar el primer mensaje del tema; este siempre esta asociado a la encuesta. Si nadie ha votado, los usuarios pueden borrar la encuesta o editar las opciones. Sin embargo, si algún miembro ha votado, solo moderadores o administradores pueden editar o borrar la encuesta. Esto evita que las encuestas sean cambiadas a mitad de la votación.'
	),
	array(
		0 => '¿Por qué no se puede acceder a algún foro?',
		1 => 'Algunos foros pueden estar limitados para ciertos usuarios o grupos y para visualizar, leer, publicar o llevar a cabo otra acción allí necesita una autorización especial. Comuníquese con un moderador o administrador del foro para que se le conceda el permiso adecuado.'
	),
	array(
		0 => '¿Por qué no se puede añadir archivos adjuntos?',
		1 => 'Los permisos para adjuntar archivos son individuales para cada foro, grupo, usuario y son concedidos por La Administración. Tal vez La Administración no permite adjuntar archivos en el foro en que se encuentra o solo ciertos grupos pueden hacerlo. Comuníquese con La Administración si no está seguro de por qué no puede adjuntar archivos.'
	),
	array(
		0 => '¿Por qué recibí una advertencia?',
		1 => 'Los administradores de cada foro tienen su propio conjunto de reglas para su sitio. Si ha quebrantado alguna regla puede recibir una advertencia. Por favor recuerde que esta es una decisión de La Administración del foro, y el phpBB Group no tiene nada que ver con las advertencias dadas en este sitio. Comuníquese con La Administración del foro si no está seguro de porqué fue advertido.'
	),
	array(
		0 => '¿Cómo se puede reportar un mensaje a un moderador?',
		1 => 'Si La Administración lo permite, debería ver un botón para reportar mensajes cerca del mismo. Haciendo clic sobre el botón, el foro le llevará y guiará a través de ciertos pasos necesarios para reportar el mensaje.'
	),
	array(
		0 => '¿Para qué sirve el botón "Guardar" en la publicación de temas?',
		1 => 'Esto le permitirá guardar borradores que serán completados y enviados más tarde. Para recargar un borrador guardado, visite el Panel de Control de Usuario.'
	),
	array(
		0 => '¿Por qué mis mensajes necesitan ser aprobados?',
		1 => 'La Administración del foro tal vez ha decidido que los mensajes publicados en el foro, en el que estas intentando publicar mensajes, necesiten ser revisados antes de aprobarlos. También es posible que La Administración le haya ubicado en un grupo de usuarios cuyos mensajes necesitan ser revisados antes de aprobarlos. Por favor comuníquese con el administrador para más información al respecto.'
	),
	array(
		0 => '¿Cómo hago para reactivar un tema?',
		1 => 'Puede hacerlo dándole clic al enlace que dice "Reactivar tema" cuando esté viendo el mismo, puede "reactivar" el tema al principio de la primera página. Sin embargo, si no lo visualiza, entonces el tema reactivado ha sido deshabilitado o el tiempo para poder reactivarlo no ha sido alcanzado aún. También es posible reactivar un tema respondiendo al mismo, sin embargo, lea las reglas del foro antes de hacerlo.'
	),
	array(
		0 => '--',
		1 => 'Formatos y tipos de temas'
	),
	array(
		0 => '¿Qué es el código BBCode?',
		1 => 'BBcode es una implementación especial de HTML, ofrece un gran control de formato de los objetos particulares de las publicaciones. El uso de BBCode debe ser habilitado por la administración, pero también puede ser deshabilitado del formulario de publicación de mensajes. BBCode asimismo es similar en estilo al HTML, pero las etiquetas se encuentran encerrados entre corchetes [ y ] en lugar de < y >. Para más información, lea el manual de BBCode. El enlace aparece cada vez que va a publicar un mensaje.'
	),
	array(
		0 => '¿Puedo usar HTML?',
		1 => 'No. No es posible publicar en HTML. Muchos de los formatos y acciones que se pueden ejecutar utilizando HTML pueden ser aplicados utilizando BBCodes.'
	),
	array(
		0 => '¿Qué son los emoticonos?',
		1 => 'Los emoticonos son pequeñas imágenes que pueden ser utilizadas para expresar un sentimiento con un pequeño código, e.j. :) denota felicidad, mientras que :( denota tristeza. La lista completa de emoticones puede verse en el formulario de publicación. Trate de no abusar del uso de emoticonos, pues pueden hacer que un mensaje se vuelva muy difícil de leer y un moderador borre el tema o los emoticones del mensaje. La administración puede fijar un límite para el número de emoticones a utilizar en un mensaje.'
	),
	array(
		0 => '¿Puedo publicar imagenes?',
		1 => 'Sí, las imágenes se pueden mostrar en sus mensajes. Si la administración permite adjuntar archivos, puede subir la imagen directamente al foro. De otra manera, debe guardar primero su foto en un servidor de acceso público, e.j. http://www.ejemplo.com/mi-imagen.gif. No puede publicar imágenes que se encuentren en su PC (a menos que sea un servidor de acceso público) ni tampoco las que se encuentren guardadas bajo mecanismos de autenticación, e.j. hotmail o yahoo correo, sitios protegidos por contraseñas, etc. Para exhibir imágenes utilice el BBCode con la etiqueta [img].'
	),
	array(
		0 => '¿Qué son los anuncios globales?',
		1 => 'Los anuncios globales contienen información importante y debería leerlos cada vez que sea posible. Éstos aparecerán al principio de cada foro y en el Panel de Control de Usuario. Los permisos para anuncios globales son otorgados por La Administración.'
	),
	array(
		0 => '¿Qué son los anuncios?',
		1 => 'Los anuncios muchas veces contienen información importante sobre el foro que se encuentra leyendo y debería leerlos cada vez que sea posible. Los anuncios aparecen al principio de cada página en el foro donde se publicaron. Como en los anuncios globales, los permisos para anuncios son otorgados por La Administración.'
	),
	array(
		0 => '¿Qué son los temas fijos?',
		1 => 'Los temas fijos aparecen en el foro por debajo de los anuncios y solo en la primer página. Muchas veces son importantes por lo que debería leerlos cada vez que sea posible. Como en los anuncios globales y anuncios, los permisos para fijar un tema son otorgados por La Administración.'
	),
	array(
		0 => '¿Qué son los temas cerrados?',
		1 => 'Los temas cerrados son temas donde los usuarios ya no pueden responder y las encuestas allí contenidas terminaron automáticamente. Los temas pueden ser cerrados por muchas razones. Esta decisión es tomada por La Administración o un moderador. Tal vez pueda cerrar sus propios temas dependiendo de los permisos que le hayan concedido los administradores.'
	),
	array(
		0 => '¿Qué son los iconos para los temas?',
		1 => 'Son imágenes elegidas por el autor del tema para indicar el contenido del mismo. La posibilidad de usar iconos en los mensajes depende de los permisos otorgados por La Administración.'
	),
	// This block will switch the FAQ-Questions to the second template column
	array(
		0 => '--',
		1 => '--'
	),
	array(
		0 => '--',
		1 => 'Niveles de usuario y grupos'
	),
	array(
		0 => '¿Qué son los Administradores?',
		1 => 'Los Administradores son los usuarios asignados con el mayor nivel de control sobre el foro entero. Estos usuarios pueden controlar todas las acciones y configuraciones del foro, incluyendo configuraciones de permisos, baneo de usuarios, creación de grupos usuarios y moderadores, etc. Dependen del fundador del foro y de los permisos que éste les ha dado. Ellos también tienen todas las capacidades de moderación en cada uno de los foros, dependiendo de las configuraciones realizadas por el fundador del sitio.'
	),
	array(
		0 => '¿Qué son los Moderadores?',
		1 => 'Los Moderadores son individuos (o grupos de individuos) que cuidan el foro día a día. Tienen la autoridad para editar o borrar mensajes, cerrarlos, abrirlos, moverlos, borrar y separar temas en el foro que moderan. Generalmente, los moderadores están presentes para evitar que los usuarios se salgan del tema tratado o publiquen spam y/o contenido malicioso.'
	),
	array(
		0 => '¿Qué son los Grupos de Usuarios?',
		1 => 'Los Grupos de Usuarios son conjuntos de usuarios que dividen a la comunidad en sectores manejables con los cuales puede trabajar los administradores del foro. Cada usuario puede pertenecer a varios grupos y cada grupo puede tener diferentes permisos. Esto ayuda, a los administradores, a cambiar los permisos de muchos usuarios a la vez, tales como los permisos de moderador, o garantizar el acceso a foros privados a los usuarios.'
	),
	array(
		0 => '¿Donde están los Grupos de Usuarios y como me puedo unir a ellos?',
		1 => 'Puede ver todos los Grupos de usuarios a través del enlace "Grupos de Usuarios". Si desea unirse a algún grupo, puede proceder haciendo clic en el botón apropiado. No todos los grupos tienen libre acceso. Sin embargo, algunos requieren aprobación para poder unirse, otros están cerrados y algunos son ocultos. Si el grupo se encuentra abierto, puede unirse haciendo clic en el botón correspondiente. Si el grupo requiere de aprobación para unirse, puede solicitar unirse haciendo clic en el botón correspondiente. El responsable del grupo deberá aprobar su solicitud y seguramente le preguntará por qué desea hacerlo. Por favor no moleste continuamente al Responsable de Grupo si rechaza su solicitud; seguramente tenga sus razones.'
	),
	array(
		0 => '¿Cómo me convierto en Responsable del Grupo?',
		1 => 'El Responsable de un grupo es asignado por La Administración al crear el grupo. Si está interesado en crear un grupo de usuarios, contacte con La Administración.'
	),
	array(
		0 => '¿Por qué algunos Grupos de Usuarios aparecen en diferentes colores?',
		1 => 'La Administración del foro tiene la posibilidad de asignar un color a los usuarios de un grupo para hacer más fácil su identificación.'
	),
	array(
		0 => '¿Qué es un "Grupo de Usuarios predeterminado"?',
		1 => 'Si es miembro de más de un grupo por defecto, se usará el "predeterminado" para determinar qué color y rango se mostrará por defecto en su perfil. La Administración debe darle permisos para cambiar su grupo por defecto mediante su Panel de Control de Usuario.'
	),
	array(
		0 => '¿Qué es el enlace "El equipo"?',
		1 => 'Esta página le provee de la lista completa de los usuarios del grupo, incluyendo los administradores, moderadores y otros detalles, como los foros que se encarga de moderar cada uno.'
	),
	array(
		0 => '--',
		1 => 'Mensajería privada'
	),
	array(
		0 => '¡No puedo enviar un mensaje privado!',
		1 => 'Hay tres razones posibles; no está registrado y/o identificado, La Administración del foro ha deshabilitado la opción de mensajes privados para todos los usuarios, o bien La Administración ha deshabilitado para usted, o su grupo de usuarios, la opción de enviar mensajes. Comuníquese con La Administración para más información.'
	),
	array(
		0 => '¡Recibo mensajes privados no deseados!',
		1 => 'Si está recibiendo mensajes maliciosos u ofensivos de un usuario en particular, puede bloquearlo para que no le pueda enviar mensajes, dentro de las opciones del Panel de Control de Usuario o comunicarlo a La Administración.'
	),
	array(
		0 => '¡Recibí spam o correos maliciosos de alguien en este foro!',
		1 => 'Lamentamos oír eso. El formulario de e-mail incluye identificadores para controlar quién ha enviado tales mensajes, por lo tanto, puede contactar con La Administración y hacerles llegar una copia completa del mensaje que recibió. Es muy importante que incluya la cabecera, ya que contiene los datos del usuario que envió el e-mail. La Administración tomará medidas.'
	),
	array(
		0 => '--',
		1 => 'Amigos e Ignorados'
	),
	array(
		0 => '¿Qué es la lista de Mis Amigos e Ignorados?',
		1 => 'Puede utilizar la lista para organizar otros usuarios del foro. Los usuarios añadidos a su lista de Amigos podrán verse en en Panel de Control de Usuario para un rápido acceso a ver si están identificados y poder así enviarles un mensaje privado. Según la plantilla que utilice el foro, los mensajes de estos usuarios pueden visualizarse resaltados. Si añade un usuario a su lista de Ignorados, todos sus mensajes quedarán ocultos.'
	),
	array(
		0 => '¿Cómo se puede añadir o borrar usuarios de mi lista de Amigos e Ignorados?',
		1 => 'Puede añadir usuarios a su lista de dos maneras. En cada perfil de usuario hay un enlace para añadirlo a su lista de Amigos y/o Ignorados. También puede hacerlo desde el Panel de Control de Usuario directamente, introduciendo su nombre. Puede eliminar usuarios de su lista desde esta misma página.'
	),
	array(
		0 => '--',
		1 => 'Búsqueda en los foros'
	),
	array(
		0 => '¿Cómo se puede buscar en uno o varios foros?',
		1 => 'Introduciendo un término de búsqueda en el campo correspondiente del buscador del índice, foro o en los temas. Puede acceder a búsquedas avanzadas haciendo clic en el enlace "Búsqueda Avanzada" que está disponible en todas las páginas del foro. La manera de acceder a la búsqueda depende de la plantilla utilizada.'
	),
	array(
		0 => '¿Por qué mi búsqueda me devuelve ningún resultado?',
		1 => 'Probablemente su búsqueda fue muy general e incluye muchos términos comunes que no son indexados por phpBB3. Sea más específico y utilice las opciones disponibles en la búsqueda avanzada.'
	),
	array(
		0 => '¿Por qué mi búsqueda me devuelve una página en blanco?',
		1 => 'La búsqueda devolvió demasiados resultados para ser procesados por el servidor. Utilice "Búsqueda Avanzada" y sea más específico en los términos y foros de su búsqueda.'
	),
	array(
		0 => '¿Cómo busco usuarios?',
		1 => 'Pulse en el enlace "Usuarios" y haga clic en el enlace "Buscar un usuario".'
	),
	array(
		0 => '¿Como se puede encontrar mis propios mensajes y temas?',
		1 => 'Puede encontrar sus mensajes haciendo clic en  "Mostrar sus mensajes" en el Panel de Control de Usuario o a través de su propio perfil. Para buscar sus temas, utilice la página de búsqueda avanzada y complete las opciones apropiadas.'
	),
	array(
		0 => '--',
		1 => 'Suscripción y Añadido de temas a Favoritos'
	),
	array(
		0 => '¿Cuál es la diferencia entre añadir como Favorito y suscribirme a un tema?',
		1 => 'Añadir un tema como Favorito en phpBB3 es como Añadir un sitio como Favorito en su navegador. No se le avisa cuando hay una actualización o respuesta, pero puede seguir visitando el tema para ver las modificaciones más tarde. Al suscribirse, a diferencia de añadir a Favoritos, se le avisará cuando haya actualizaciones en los temas y foros que haya seleccionado.'
	),
	array(
		0 => '¿Cómo me suscribo a un foro o tema específico?',
		1 => 'Para suscribirse a un foro en especial, debe hacer clic en el enlace "Suscribir Foro". Para suscribirse a un tema, debe activar la casilla "Suscribir" cuando envía una respuesta al mismo, o hacer clic en el enlace "Suscribir tema".'
	),
	array(
		0 => '¿Cómo borro mis suscripciones?',
		1 => 'Para eliminar sus suscripciones, debe entrar en el Panel de Control de Usuario y hacer clic en la opción "Organizar suscripciones".'
	),
	array(
		0 => '--',
		1 => 'Archivos Adjuntos'
	),
	array(
		0 => '¿Qué archivos adjuntos son permitidos en este foro?',
		1 => 'Cada foro puede permitir o no ciertos tipos de archivos adjuntos. Si no está seguro de que tipos de archivos se pueden cargar, comuníquese con La Administración para obtener más información.'
	),
	array(
		0 => '¿Cómo encuentro todos mis archivos adjuntos?',
		1 => 'Para encontrar la lista de sus archivos adjuntos, debe entrar en el Panel de Control de Usuario y hacer clic en la opción "Organizar adjuntos".'
	),
	array(
		0 => '--',
		1 => 'Acerca de phpBB3'
	),
	array(
		0 => '¿Quién programó este foro?',
		1 => 'Esta aplicación (en su forma original) es desarrollada, publicada y contiene derechos de autor pertenecientes a <a href="https://www.phpbb.com/">phpBB Group</a>. Está hecho bajo la GNU (Licencia Pública General) y es de libre distribución. Visite el enlace para más detalles.'
	),
	array(
		0 => '¿Por qué este foro no tiene tal cosa?',
 		1 => 'Este foro fue escrito y licenciado a través de phpBB Group. Si usted cree que se debe añadir alguna característica por favor visite <a href="https://www.phpbb.com/ideas/">Centro de phpBB Ideas</a> (en Inglés), donde se puede votar en ideas existentes o sugerir nuevas características.'
	),
	array(
		0 => '¿Con quién se puede contactar acerca de abusos o usos ilegales relacionados con este foro?',
		1 => 'Cada uno de los administradores que figuran en la lista del grupo donde dice "El Equipo" es un contacto apropiado para enviar sus quejas. Si así no obtiene respuesta debería tratar de contactar con el dueño del dominio (efectúe una <a href="http://www.google.com/search?q=whois">búsqueda whois</a>) o, si este foro tiene correo sobre un dominio gratuito (Yahoo!, gmail.com, hotmail.com, etc.), al departamento o administración de abusos de ese servicio. Por favor, tenga en cuenta que el Grupo phpBB <strong>carece de cualquier tipo de control</strong> y no puede ser de ninguna manera responsable sobre cómo, dónde o por quién es usado este sistema de foros. No tiene ningún sentido contactar con el Grupo phpBB en relación a asuntos legales (difamación, responsabilidad, deformación de comentarios, etc.) que no sean con respecto al sitio phpbb.com o la discreción misma del software phpBB. Si envia un correo al Grupo phpBB <strong>respecto del uso de terceras partes</strong> de este software esté dispuesto a recibir una respuesta cortante o directamente no recibir respuesta.'
	)
);

?>