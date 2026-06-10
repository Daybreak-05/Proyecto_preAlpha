<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket <?php echo e($pedido['codigo']); ?></title>
</head>
<body style="margin:0;padding:0;background:#eef1eb;font-family:Arial,Helvetica,sans-serif;color:#0f172a;">
    <div style="max-width:640px;margin:0 auto;padding:24px;">
        <div style="background:#ffffff;border:1px solid #dbe4d0;border-radius:18px;overflow:hidden;box-shadow:0 14px 32px rgba(15,23,42,.08);">
            <div style="background:linear-gradient(135deg,#0f172a,#0f766e);color:#fff;padding:24px 28px;">
                <p style="margin:0;font-size:12px;letter-spacing:.22em;text-transform:uppercase;color:#a7f3d0;">ALMACÉNPRO</p>
                <h1 style="margin:10px 0 6px;font-size:28px;line-height:1.1;">Tu ticket está listo</h1>
                <p style="margin:0;color:#d1fae5;">Código <?php echo e($pedido['codigo']); ?> · <?php echo e($pedido['fecha']); ?></p>
            </div>

            <div style="padding:28px;">
                <p style="margin:0 0 18px;font-size:15px;line-height:1.6;">Gracias por tu compra. Adjuntamos el ticket en PDF y te dejamos un resumen rápido de tu pedido.</p>

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                    <?php $__currentLoopData = $pedido['detalles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;">
                                <strong style="display:block;margin-bottom:4px;"><?php echo e($linea['nombre']); ?></strong>
                                <span style="color:#64748b;font-size:13px;"><?php echo e($linea['cantidad']); ?> x <?php echo e(number_format($linea['precio_unitario'], 2, ',', '.')); ?> €</span>
                            </td>
                            <td style="padding:10px 0;border-bottom:1px solid #e2e8f0;text-align:right;font-weight:700;white-space:nowrap;">
                                <?php echo e(number_format($linea['subtotal'], 2, ',', '.')); ?> €
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>

                <div style="margin-top:20px;padding:16px;border-radius:14px;background:#f8fafc;border:1px solid #e2e8f0;">
                    <p style="margin:0 0 6px;font-size:12px;text-transform:uppercase;letter-spacing:.18em;color:#64748b;font-weight:700;">Método de pago</p>
                    <p style="margin:0;font-weight:700;"><?php echo e(strtoupper($pedido['metodo_pago'])); ?></p>
                    <p style="margin:12px 0 0;font-size:12px;text-transform:uppercase;letter-spacing:.18em;color:#64748b;font-weight:700;">Total</p>
                    <p style="margin:0;font-size:24px;font-weight:800;color:#0f172a;"><?php echo e(number_format($pedido['total'], 2, ',', '.')); ?> €</p>
                </div>

                <p style="margin:22px 0 0;font-size:13px;color:#64748b;">Si necesitas reenviar el ticket, puedes hacerlo desde la pantalla final de tu compra.</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/emails/ticket.blade.php ENDPATH**/ ?>