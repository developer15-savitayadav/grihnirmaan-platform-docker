<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="gn-dashboard">
<div class="gn-dashboard-overview">
    
    <div class="gn-welcome-card">

        <div class="gn-user-info">
            <div>


                <h2><?php echo e(auth()->user()->name); ?></h2>

                <p>
                    <?php echo e(ucfirst(auth()->user()->role)); ?>

                    •
                    <?php echo e(now()->format('l, d M Y')); ?>

                </p>
            </div>

        </div>

        <div class="gn-user-actions">

            <div class="gn-mini-card">
                <span>Today's Leads</span>
                <strong><?php echo e($todayLeads); ?></strong>
            </div>

            <div class="gn-mini-card">
                <span>Last Login</span>
                <strong>
                    <?php echo e(optional(auth()->user()->last_login_at)->diffForHumans() ?? 'Today'); ?>

                </strong>
            </div>

        </div>

    </div>

        
     <div class="gn-card-grid">

    <div class="gn-card">
        <div class="gn-card-content">
            <p>Total Leads</p>
            <h2><?php echo e(number_format($totalLeads)); ?></h2>
            <span>All customer inquiries</span>
        </div>

        <div class="gn-card-icon icon-navy">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
    </div>

    <div class="gn-card">
        <div class="gn-card-content">
            <p>New Leads</p>
            <h2><?php echo e(number_format($newLeads)); ?></h2>
            <span>Pending follow up</span>
        </div>

        <div class="gn-card-icon icon-green">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 6v6l4 2"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>
        </div>
    </div>

    <div class="gn-card">
        <div class="gn-card-content">
            <p>Pipeline Value</p>
         <h2><?php echo e($pipelineValue); ?></h2>
            <span>Potential project value</span>
        </div>

        <div class="gn-card-icon icon-orange">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2v20"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
        </div>
    </div>

    <div class="gn-card">
        <div class="gn-card-content">
            <p>Conversion Rate</p>
            <h2><?php echo e($conversionRate); ?>%</h2>
            <span>Average conversion</span>
        </div>

        <div class="gn-card-icon icon-blue">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                <path d="M22 12A10 10 0 0 0 12 2v10z"/>
            </svg>
        </div>
    </div>

</div>
</div>


        
        <div class="gn-graph-grid">
            <div class="gn-graph-card">
                <div class="gn-graph-head">
                    <div>
                        <h3>Monthly Leads</h3>
                        <p>Lead generation this year</p>
                    </div>
                </div>

                <div class="gn-chart-wrap">
                    <canvas id="monthlyLeadsChart"></canvas>
                </div>
            </div>

            <div class="gn-graph-card">
                <div class="gn-graph-head">
                    <div>
                        <h3>Leads by Source</h3>
                        <p>Top marketing channels</p>
                    </div>
                </div>

                <div class="gn-chart-wrap">
                    <canvas id="sourceChart"></canvas>
                </div>
            </div>
        </div>

<div class="gn-filament-table-card">
    <?php echo e($this->table); ?>

</div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const monthlyLabels = <?php echo json_encode($monthlyLabels, 15, 512) ?>;
        const monthlyValues = <?php echo json_encode($monthlyValues, 15, 512) ?>;

        const sourceLabels = <?php echo json_encode($sourceLabels, 15, 512) ?>;
        const sourceValues = <?php echo json_encode($sourceValues, 15, 512) ?>;

        const monthlyCtx = document.getElementById('monthlyLeadsChart').getContext('2d');
        const monthlyGradient = monthlyCtx.createLinearGradient(0, 0, 0, 280);
        monthlyGradient.addColorStop(0, 'rgba(31, 78, 121, 0.25)');
        monthlyGradient.addColorStop(1, 'rgba(31, 78, 121, 0.02)');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Leads',
                    data: monthlyValues,
                    borderColor: '#1F4E79',
                    backgroundColor: monthlyGradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.45,
                    pointBackgroundColor: '#D4A853',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1F2A37',
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F1EF' },
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        new Chart(document.getElementById('sourceChart'), {
            type: 'doughnut',
            data: {
                labels: sourceLabels,
                datasets: [{
                    data: sourceValues,
                    backgroundColor: [
                        '#1F4E79',
                        '#2E75B6',
                        '#D4A853',
                        '#C4623A',
                        '#2E7D32',
                        '#6B6560'
                    ],
                    borderWidth: 4,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 16,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH C:\Users\HP\Grihnirmaan\resources\views/filament/pages/dashboard.blade.php ENDPATH**/ ?>