@php
    $arrParams = [];
    if(count($model->params) > 0){
        $arrParams = unserialize($model->params);
    }

    if(isset($_GET['params'])){
        $temp_arrParams = $_GET['params'];

        foreach ($temp_arrParams['name'] as $key => $item){
            $arrParams[] = array(
                'name' => $item,
                'value' => $temp_arrParams['value'][$key]
                );
        }
    }
    //dd($arrParams);
@endphp

<div class="b-admin-parameter">
    <div class="row hidden-sm" style="margin-bottom: 25px;">
        <div class="col-md-4">
            Название параметра
        </div>
        <div class="col-md-4">
            Значение параметра
        </div>
    </div>

    <div class="js-row-add-content hidden">
        <div class="row js-row-params-#id#" style="margin-top: 15px;">
            <div class="col-md-4">
                <div class="form-group form-element-text ">
                    <input type="text" name="params[name][]" value="" placeholder="Название параметра"
                           class="form-control js-input-params">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-element-text ">
                    <input type="text" name="params[value][]" value="" placeholder="Значение параметра"
                           class="form-control js-input-params">
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-delete js-delete-row-params"
                        data-id-row-params="#id#">
                    <i class="fa fa-times"></i>
                    Удалить
                </button>
            </div>
        </div>
    </div>

    <div class="js-params-container">
    @if(count($arrParams) > 0)
        @foreach($arrParams as $param)

                <div class="row js-row-params-{{$loop->index}}">
                    <div class="col-md-4">
                        <div class="form-group form-element-text ">
                            <input type="text" name="params[name][]" placeholder="Название параметра"
                                   value="{{$param['name']}}" class="form-control  js-input-params">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-element-text ">
                            <input type="text" name="params[value][]" placeholder="Значение параметра"
                                   value="{{$param['value']}}" class="form-control  js-input-params">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-delete js-delete-row-params"
                                data-id-row-params="{{$loop->index}}">
                            <i class="fa fa-times"></i>
                            Удалить
                        </button>
                    </div>
                </div>

        @endforeach
    @else
            <div class="row js-row-params-0">
                <div class="col-md-4">
                    <div class="form-group form-element-text ">
                        <input type="text" name="params[name][]" placeholder="Название параметра"
                               value="" class="form-control  js-input-params">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-element-text ">
                        <input type="text" name="params[value][]" placeholder="Значение параметра"
                               value="" class="form-control  js-input-params">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-delete js-delete-row-params"
                            data-id-row-params="0">
                        <i class="fa fa-times"></i>
                        Удалить
                    </button>
                </div>
            </div>
    @endif
    </div>
    <div class="row" style="margin-top: 15px;margin-bottom: 25px;">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary js-add-row-params">
                <i class="fa fa-plus"></i>
                Добавить строку параметров
            </button>
        </div>
    </div>

</div>

<script src="/js/libs/jquery/dist/jquery.min.js"></script>
<script>
    @if(count($arrParams) > 0)
        var countRowParametrs = {{count($arrParams)}} +(+1);
    @else
        var countRowParametrs = 1;
    @endif


$(document).on('click', '.js-delete-row-params', function () {
        console.log($(this).attr('data-id-row-params'));
        $('.js-row-params-' + $(this).attr('data-id-row-params')).remove();
    });

    $(document).on('click', '.js-add-row-params', function () {
        var contentRow = $('.js-row-add-content').html();
        contentRow = contentRow.replace(/#id#/g, countRowParametrs);
        countRowParametrs++;

        $('.js-params-container').append(contentRow);
    });

</script>