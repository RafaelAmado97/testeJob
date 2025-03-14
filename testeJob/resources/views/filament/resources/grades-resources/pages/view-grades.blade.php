@extends('filament::page')

@section('content')
    <div>
        <h1>My Grades</h1>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Nota 1</th>
                    <th>Nota 2</th>
                    <th>Nota 3</th>
                    <th>Nota 4</th>
                    <th>Final Exam Grade</th>
                    <th>Total Grade</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($record as $grade)
                    <tr>
                        <td>{{ $grade->student_name }}</td>
                        <td>{{ $grade->nota_1 }}</td>
                        <td>{{ $grade->nota_2 }}</td>
                        <td>{{ $grade->nota_3 }}</td>
                        <td>{{ $grade->nota_4 }}</td>
                        <td>{{ $grade->nota_prova_final }}</td>
                        <td>{{ $grade->nota_total }}</td>
                        <td>{{ $grade->media }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
