<div class="ibox-content">
    <div class="form-group">
        <div class="col-lg-1 text-right">
            {!! Form::label('name', 'Naam', ['class'=>'control-label']) !!}
        </div>
        <div class="col-lg-11">
            {!! Form::bsText('name', $projectgroup->name, ['placeholder' => '(verplicht)']) !!}
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    <div class="panel panel-default" style="margin-top: 20px;">
        <div class="panel-heading">Projecten</div>
        <div class="row">
            <div class="col-lg-8">
                <p class="text-muted" style="padding: 20px 0 0 20px;">Aantal mantis projecten met sprints: <span id="project-count">{{ $projects->count() }}</span></p>
            </div>
            <div class="col-lg-4">
                <div class="input-group" style="margin: 15px;">
                    <input type="text" id="search-input" class="form-control input-sm" placeholder="Zoeken...">
                    <span class="input-group-btn">
                        <button id="search-btn" class="btn btn-success btn-sm"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
        </div>
        @if ($projects && $projects->count() > 0)
            <ul class="list-group">
            @foreach($projects as $project)
                <li class="list-group-item">
                    {!! Form::icheck('projects['.$project->id.']', ($project->projectgroups && $project->projectgroups->where('id', $projectgroup->id)->first() ? true : false), $project->name) !!} {{ $project->name }} <span class="label label-default pull-right" title="Aantal sprints">{{ $project->sprints }}</span>
                </li>
            @endforeach
            </ul>
        @else
            <p>Geen projecten om weer te geven</p>
        @endif
    </div>

    <div class="ibox-content lg-no-margins">
        {!! Form::submit('Opslaan', ['class' => 'btn btn-sm btn-success']) !!}
        <a href="{{ route('projectgroup.index') }}" class="btn btn-sm btn-default">Terug</a>
        @if ($projectgroup->id)
        <a href="#" id="delete-projectgroup-btn" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Agile project verwijderen</a>
        @endif
    </div>
</div>
