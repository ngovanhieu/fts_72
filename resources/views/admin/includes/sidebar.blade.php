<ul class="nav nav-pills nav-stacked panel panel-default sidebar">
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/subject.subject') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/subjects/create']) !!}">
                <a href="{!! action('Admin\SubjectsController@create') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.create') }}
                </a>
            </li>
            <li class="{!! set_active(['admin/subjects']) !!}">
                <a href="{!! action('Admin\SubjectsController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/question.question') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/questions/create']) !!}">
                <a href="{!! action('Admin\QuestionsController@create') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.create') }}
                </a>
            </li>
            <li class="{!! set_active(['admin/questions']) !!}">
                <a href="{!! action('Admin\QuestionsController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/user.user') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/users/create']) !!}">
                <a href="{!! action('Admin\UsersController@create') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.create') }}
                </a>
            </li>
            <li class="{!! set_active(['admin/users']) !!}">
                <a href="{!! action('Admin\UsersController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/exams.exams') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/exams']) !!}">
                <a href="{!! action('Admin\ExamsController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
    <li role="presentation">
        <a href="#"><strong>{{ trans('admin/chart.chart') }}</strong></a>
        <ul class="nav nav-pills nav-stacked fa-ul">
            <li class="{!! set_active(['admin/chart']) !!}">
                <a href="{!! action('Admin\ChartsController@index') !!}">
                    <i class="fa-li fa fa-caret-right"></i>{{ trans('common/buttons.list') }}
                </a>
            </li>
        </ul>
    </li>
</ul>
