<div style="margin:0px 50px 0px 50px;">

    @if($services)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Name</th>
                <th>Text</th>
                <th>Icon</th>
                <th>Date of creation</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            @foreach($services as $k=>$service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{!! Html::link(route('serviceEdit', ['portfolio' => $service->id]), $service->name) !!}</td>

                    <td>{{ $service->text }}</td>

                    <td>{{ $service->icon }}</td>
                    <td>{{ $service->created_at }}</td>
                    <td>
                        {!! Form::open(['url' => route('serviceEdit', ['service' => $service->id]), 'class' => 'form-horizontal', 'method' => 'delete']) !!}

                        {!! method_field('delete') !!}

                        {!! Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

    {!! Html::link(route('serviceAdd'), 'New Service') !!}

</div>