<x-filament::widget>
    <div>
        <h2>Percentual de Alunos Aprovados e Reprovados</h2>
        <canvas id="pieChart"></canvas>
    </div>
    <div>
        <h2>Média Geral dos Alunos por Professor</h2>
        <canvas id="barChart"></canvas>
    </div>
    <div>
        <h2>Número de Alunos por Professor com % de Aprovados</h2>
        <canvas id="advancedBarChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const data = @json($this->getData());

            // Gráfico de Pizza
            new Chart(document.getElementById('pieChart'), {
                type: 'pie',
                data: {
                    labels: ['Aprovados', 'Reprovados'],
                    datasets: [{
                        data: [data.approved, data.reproved],
                        backgroundColor: ['#4CAF50', '#F44336'],
                    }]
                }
            });

            // Gráfico de Barras
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: {
                    labels: data.averageGrades.map(item => item.teacher_id),
                    datasets: [{
                        label: 'Média Geral',
                        data: data.averageGrades.map(item => item.average),
                        backgroundColor: '#2196F3',
                    }]
                }
            });

            // Gráfico de Barras Avançado
            new Chart(document.getElementById('advancedBarChart'), {
                type: 'bar',
                data: {
                    labels: data.studentsPerTeacher.map(item => item.teacher_id),
                    datasets: [{
                        label: 'Número de Alunos',
                        data: data.studentsPerTeacher.map(item => item.total),
                        backgroundColor: '#FFC107',
                    }, {
                        label: '% de Aprovados',
                        data: data.approvedPerTeacher.map(item => (item.approved / item.total) * 100),
                        type: 'line',
                        borderColor: '#4CAF50',
                        fill: false,
                    }]
                }
            });
        });
    </script>
</x-filament::widget>
