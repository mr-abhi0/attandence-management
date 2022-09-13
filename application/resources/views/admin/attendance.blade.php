@extends('layouts.default')

    @section('meta')
        <title>Attendance | Workday Time Clock</title>
        <meta name="description" content="Workday attendance, view all employee attendances, clock-in, edit, and delete attendances.">
    @endsection

    @section('styles')
        <link href="{{ asset('/assets/vendor/mdtimepicker/mdtimepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/vendor/air-datepicker/dist/css/datepicker.min.css') }}" rel="stylesheet">
        <style>
            .datepicker {z-index: 9999}
        </style>
    @endsection

    @section('content')
    @include('admin.modals.modal-add-attendance')

    <div class="container-fluid">
        <div class="row">
            <h2 class="page-title">{{ __('Attendances') }}
                <a href="{{ url('clock') }}" target="_blank" class="ui positive button mini offsettop5 float-right"><i class="ui icon clock"></i>{{ __('View web clock') }}</a>
                <button class="ui primary button mini offsettop5 btn-add float-right"><i class="ui icon plus circle"></i>{{ __("Manual entry") }}</button>
            </h2>
        </div>  

        <div class="row">
            <div class="box box-success">
                <div class="box-body reportstable">
                    <!--form action="{{ url('export/report/attendance') }}" method="post" accept-charset="utf-8" class="ui small form form-filter" id="filterform">
                        {{ csrf_field() }}
                        <div class="inline three fields">
                            <div class="two wide field">
                                <input id="datefrom" type="text" name="datefrom" value="" placeholder="Start Date" class="airdatepicker">
                                <i class="ui icon calendar alternate outline calendar-icon"></i>
                            </div>

                            <div class="two wide field">
                                <input id="dateto" type="text" name="dateto" value="" placeholder="End Date" class="airdatepicker">
                                <i class="ui icon calendar alternate outline calendar-icon"></i>
                            </div>

                            <input type="hidden" name="emp_id" value="">
                            <button id="btnfilter" class="ui icon button positive small inline-button"><i class="ui icon filter alternate"></i> {{ __("Filter") }}</button>
                        </div>
                    </form-->

                    <table width="100%" class="table table-striped table-hover" id="dataTables-example" data-order='[[ 0, "desc" ]]'>
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
				<th>{{ __('DP Code') }}</th>
                                <th>{{ __('Employee') }}</th>
 <th>{{ __('Company') }}</th>
                                <th>{{ __('Time In') }}</th>
                                <th>{{ __('Time Out') }}</th>
                                <th>{{ __('Total Hours') }}</th>
                                <th>{{ __('Status (In/Out)') }}</th>
                                @isset($ss)
                                    @if($ss->clock_comment == "on")
                                        <th>Comment</th>
                                    @endif
                                @endisset
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($data)
                            @foreach ($data as $d)
                            <tr>
                                <td>{{ $d->date }}</td>
				 <td>{{ $d->idno }}</td>
                                <td>{{ $d->employee }}</td>
                            <td>{{ $d->company }}</td>
                                <td>
                                    @php 
                                        if($ss->time_format == 1) {
                                            echo e(date('h:i:s A', strtotime($d->timein)));
                                        } else {
                                            echo e(date('H:i:s', strtotime($d->timein)));
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @isset($d->timeout)
                                        @php 
                                            if($ss->time_format == 1) {
                                                echo e(date('h:i:s A', strtotime($d->timeout)));
                                            } else {
                                                echo e(date('H:i:s', strtotime($d->timeout)));
                                            }
                                        @endphp
                                    @endisset
                                </td>
                                <td>
                                    @isset($d->totalhours)
                                        @if($d->totalhours != null) 
                                            @php
                                                if(stripos($d->totalhours, ".") === false) {
                                                    $h = $d->totalhours;
                                                } else {
                                                    $HM = explode('.', $d->totalhours); 
                                                    $h = $HM[0]; 
                                                    $m = $HM[1];
                                                }
                                            @endphp
                                        @endif
                                        @if($d->totalhours != null)
                                            @if(stripos($d->totalhours, ".") === false) 
                                                {{ $h }} hr
                                            @else 
                                                {{ $h }} hr {{ $m }} mins
                                            @endif
                                        @endif
                                    @endisset
                                </td>
                                <td>
                                    @if($d->status_timein != null OR $d->status_timeout != null) 
                                        <span class="@if($d->status_timein == 'Late In') orange @else blue @endif">{{ $d->status_timein }}</span> / 
                                        @isset($d->status_timeout) 
                                            <span class="@if($d->status_timeout == 'Early Out') red @else green @endif">
                                                {{ $d->status_timeout }}
                                            </span> 
                                        @endisset
                                    @else
                                        <span class="blue">{{ $d->status_timein }}</span>
                                    @endif 
                                </td>
                                @isset($ss)
                                    @if($ss->clock_comment == "on")
                                        <td>{{ $d->comment }}</td>
                                    @endif
                                @endisset
                                <td class="align-right">
                                    <a href="{{ url('/attendance/edit/'.$d->id) }}" class="ui circular basic icon button tiny"><i class="edit outline icon"></i></a>
                                    <a href="{{ url('/attendance/delete/'.$d->id) }}" class="ui circular basic icon button tiny"><i class="trash alternate outline icon"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>

    @endsection

    @section('scripts')
    <script src="{{ asset('/assets/vendor/mdtimepicker/mdtimepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/air-datepicker/dist/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/air-datepicker/dist/js/i18n/datepicker.en.js') }}"></script>
    <script src="{{ asset('/assets/vendor/momentjs/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/momentjs/moment-timezone-with-data.js') }}"></script>
    
    <script type="text/javascript">
    $('#dataTables-example').DataTable({responsive: true,pageLength: 30,lengthChange: false,searching: true,ordering: true});
    $('.jtimepicker').mdtimepicker({format:'h:mm tt', theme: 'blue', hourPadding: true});
    $('.airdatepicker').datepicker({ language: 'en', dateFormat: 'yyyy-mm-dd' });
    
    $('.ui.dropdown.getref').dropdown({ onChange: function(value, text, $selectedItem) {
        $('select[name="name"] option').each(function() {
            if($(this).val()==value) {
                var r = $(this).attr('data-ref');
                $('input[name="ref"]').val(r);
            };
        });
    }});

   
    </script>
    @endsection
