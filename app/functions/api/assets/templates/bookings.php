<table style="border: solid 1px #661FFF;">
    <tr>
        <th style="background: #661FFF; color: white;">ID</th>
        <th style="background: #661FFF; color: white;">Fecha</th>
        <th style="background: #661FFF; color: white;">Nombres</th>
        <th style="background: #661FFF; color: white;">Email</th>
        <th style="background: #661FFF; color: white;">Celular</th>
        <th style="background: #661FFF; color: white;">Producto</th>
        <th style="background: #661FFF; color: white;">Dudas</th>
        <th style="background: #661FFF; color: white;">Fecha</th>
        <th style="background: #661FFF; color: white;">Hora</th>
        <th style="background: #661FFF; color: white;">Politicas de privacidad</th>
        <th style="background: #661FFF; color: white;">LG Publicidad</th>
    </tr>
    <tbody>
        <?php 
            $index = 0;

            foreach($bookings as $booking) { 
                $bg     = ( $index % 2 == 0 ) ? '#EEE8F6' : 'white';
        ?>
            <tr>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->id ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->created_at ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo wp_strip_all_tags($booking->fullname) ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->email ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->phone ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->product ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo wp_strip_all_tags($booking->message) ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->date ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->hour ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->politics ? 'Si' : 'No' ?></td>
                <td style="background: <?php echo $bg; ?>;"><?php echo $booking->news ? 'Si' : 'No' ?></td>
            </tr>
        <?php $index++; } ?>
    </tbody>
</table>
