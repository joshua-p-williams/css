@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.categories.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_view')
        </div>

        <div class="panel-body table-responsive">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>@lang('quickadmin.categories.fields.name')</th>
                            <td field-key='name'>{{ $category->name }}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    
<li role="presentation" class="active"><a href="#participants" aria-controls="participants" role="tab" data-toggle="tab">Participants</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    
<div role="tabpanel" class="tab-pane active" id="participants">
<table class="table table-bordered table-striped {{ count($participants) > 0 ? 'datatable' : '' }}">
    <thead>
        <tr>
            <th>@lang('quickadmin.participants.fields.team')</th>
                        <th>@lang('quickadmin.participants.fields.category')</th>
                        <th>@lang('quickadmin.participants.fields.name')</th>
                        <th>@lang('quickadmin.participants.fields.phone')</th>
                        <th>@lang('quickadmin.participants.fields.email')</th>
                        <th>@lang('quickadmin.participants.fields.address')</th>
                                                <th>&nbsp;</th>

        </tr>
    </thead>

    <tbody>
        @if (count($participants) > 0)
            @foreach ($participants as $participant)
                <tr data-entry-id="{{ $participant->id }}">
                    <td field-key='team'>{{ $participant->team->name or '' }}</td>
                                <td field-key='category'>{{ $participant->category->name or '' }}</td>
                                <td field-key='name'>{{ $participant->name }}</td>
                                <td field-key='phone'>{{ $participant->phone }}</td>
                                <td field-key='email'>{{ $participant->email }}</td>
                                <td field-key='address'>{{ $participant->address }}</td>
                                                                <td>
                                    @can('view')
                                    <a href="{{ route('participants.show',[$participant->id]) }}" class="btn btn-xs btn-primary">@lang('quickadmin.qa_view')</a>
                                    @endcan
                                    @can('edit')
                                    <a href="{{ route('participants.edit',[$participant->id]) }}" class="btn btn-xs btn-info">@lang('quickadmin.qa_edit')</a>
                                    @endcan
                                    @can('delete')
{!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("quickadmin.qa_are_you_sure")."');",
                                        'route' => ['participants.destroy', $participant->id])) !!}
                                    {!! Form::submit(trans('quickadmin.qa_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="11">@lang('quickadmin.qa_no_entries_in_table')</td>
            </tr>
        @endif
    </tbody>
</table>
</div>
</div>

            <p>&nbsp;</p>

            <a href="{{ route('admin.categories.index') }}" class="btn btn-default">@lang('quickadmin.qa_back_to_list')</a>
        </div>
    </div>
@stop
