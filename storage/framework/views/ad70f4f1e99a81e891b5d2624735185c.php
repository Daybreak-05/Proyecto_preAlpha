<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket <?php echo e($pedido['codigo']); ?></title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #0f172a;
            margin: 0;
            padding: 28px;
            background: #f8fafc;
        }
        .card {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 18px;
            padding: 24px;
        }
        .header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .title {
            font-size: 26px;
            font-weight: 700;
            margin: 0;
        }
        .muted {
            color: #64748b;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            text-align: left;
            padding: 10px 8px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        th {
            background: #f8fafc;
            font-weight: 700;
        }
        .summary {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }
        .box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 12px 14px;
            flex: 1;
        }
        .total {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <p class="muted">ALMACÉNPRO</p>
            <h1 class="title">Ticket de compra <?php echo e($pedido['codigo']); ?></h1>
            <p class="muted">Fecha: <?php echo e($pedido['fecha']); ?> · Estado: <?php echo e($pedido['estado']); ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pedido['detalles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($linea['nombre']); ?></td>
                        <td><?php echo e($linea['cantidad']); ?></td>
                        <td><?php echo e(number_format($linea['precio_unitario'], 2, ',', '.')); ?> €</td>
                        <td><?php echo e(number_format($linea['subtotal'], 2, ',', '.')); ?> €</td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="summary">
            <div class="box">
                <strong>Método de pago</strong><br>
                <span class="muted"><?php echo e(strtoupper($pedido['metodo_pago'])); ?></span>
            </div>
            <div class="box" style="text-align:right;">
                <strong>Total pagado</strong><br>
                <span class="total"><?php echo e(number_format($pedido['total'], 2, ',', '.')); ?> €</span>
            </div>
        </div>

        <p class="muted" style="margin-top: 18px;">Correo de envío: <?php echo e($pedido['correo_ticket'] ?? 'No indicado'); ?></p>
    </div>
</body>
</html>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/pedidos/pdf.blade.php ENDPATH**/ ?>