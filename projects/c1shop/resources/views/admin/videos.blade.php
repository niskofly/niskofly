@php
    $field_name = 'videos';
    $dbValue = $model->$field_name;

    if($dbValue)
        $renderResult = explode(',', $dbValue);
    else
        $renderResult = [];
    
@endphp

<div class="b-admin-parameter">
    <input type="hidden" value="{{$model->$field_name}}" class="js-video-input-result" name="{{$field_name}}">

    <div class="row hidden-sm" style="margin-bottom: 25px;">
        <div class="col-md-12 control-label">
            <label class="control-label">
                URL видео (Пример https://www.youtube.com/watch?v=ID [копирование из адресной строки])
            </label>
        </div>
    </div>

    <div class="js-video-copy-row hidden">
        <div class="row js-video-row">
            <div class="col-md-10">
                <div class="form-group form-element-text ">
                    <input type="text" value="" placeholder="Название параметра"
                        class="form-control js-video-input">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-delete js-video-delete-row">
                    <i class="fa fa-times"></i> Удалить
                </button>
            </div>
        </div>
    </div>

    <div class="js-video-items">
        @if(count($renderResult) > 0)
            @foreach($renderResult as $video)
                <div class="row js-video-row">
                    <div class="col-md-10">
                        <div class="form-group form-element-text ">
                            <input type="text" placeholder="Название параметра"
                                value="{{$video}}" class="form-control js-video-input">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-delete js-video-delete-row">
                            <i class="fa fa-times"></i>
                            Удалить
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row js-video-row">
                <div class="col-md-10">
                    <div class="form-group form-element-text ">
                        <input type="text"  value="" placeholder="Название параметра"
                            class="form-control js-video-input">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-delete js-video-delete-row">
                        <i class="fa fa-times"></i>
                        Удалить
                    </button>
                </div>
            </div>
        @endif
    </div>
    <div class="row" style="margin-top: 15px;margin-bottom: 25px;">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary js-video-add-row-action">
                <i class="fa fa-plus"></i>
                Добавить строку параметров
            </button>
        </div>
    </div>

</div>
<script src="/js/libs/jquery/dist/jquery.min.js"></script>
<script>
    videoInput = {
        init: function () {
           this.eventHandler();
        },

        eventHandler: function() {
            var self = this;

            $(document).on('click', '.js-video-add-row-action', function() {
                $('.js-video-items').append($('.js-video-copy-row').html());
                self.writeResult()
            });

            $(document).on('click', '.js-video-delete-row', function() {
                $(this).closest('.js-video-row').remove();
                self.writeResult()
            });

            $(document).on('change', '.js-video-input', function() {
                self.writeResult()
            });
        },

        writeResult: function() {
            var result = [];

            $('.js-video-input').each(function() {
                if($(this).val()) {
                    result.push($(this).val());
                }
            });

            $('.js-video-input-result').val(result.join(','))
        }
    };
    videoInput.init()
</script>