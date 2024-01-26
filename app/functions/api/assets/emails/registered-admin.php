<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background: #9d003414; padding: 3rem 0; font-family: Sans-Serif">
    <tr>
    <td width="100%" align="center" style="padding: 0 1rem">
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td width="600" align="center">
            <div style="background: #9d0034; color: white; width: 100%; max-width: 640px;">
                <header style="background: white; padding: 1rem;">
                    <img src="<?= get_template_directory_uri() ?>/static/public/logo.png" style="width: 100px;">
                </header>

                <div style="padding: 1rem;">
                    <h1 style="font-size: 25px; color: white;">LG - Nueva Reserva</h1>

                    <table style="width: 100%; padding-left: 1.5rem">          
                        <tbody style="width: 100%">
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Nombre Completo: </td>
                                <td style="padding: 10px 0; color: white;"><?= wp_strip_all_tags($data['fullname'])?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Email: </td>
                                <td style="padding: 10px 0; color: white; background: #fff"><?= $data['email'] ?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Teléfono: </td>
                                <td style="padding: 10px 0; color: white;"><?= $data['phone'] ?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Producto: </td>
                                <td style="padding: 10px 0; color: white;"><?= $data['product'] ?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Mensaje: </td>
                                <td style="padding: 10px 0; color: white;"><?= wp_strip_all_tags($data['message']) ?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Fecha: </td>
                                <td style="padding: 10px 0; color: white;"><?= $data['date'] ?></td>     
                            </tr>
                            <tr>
                                <td style="padding: 10px 0; width: 30%; font-weight: bold; color: white; font-weight:bold">Hora: </td>
                                <td style="padding: 10px 0; color: white;"><?= $data['hour'] ?></td>     
                            </tr>
                        </tbody>
                    </table>
                </div>

                <footer style="text-align: center; font-size: 12px; font-family: Sans-Serif; padding: 1rem; color: #9d0034; background: white;">
                    All rights reserved - LG
                </footer>         
            </div>
            </td>
        </tr>
        </table>
    </td>
    </tr>
</table> 
