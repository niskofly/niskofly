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


        function array_depth(array $array) {
            $max_depth = 1;

            foreach ($array as $value) {
                if (is_array($value)) {
                    $depth = array_depth($value) + 1;

                    if ($depth > $max_depth) {
                        $max_depth = $depth;
                    }
                }
            }

            return $max_depth;
        }

        if (array_depth($arrParams) != 4){
            $arrParams = [
                [
                    'id' => 1,
                    'name' => 'Характеристики',
                    'items' => $arrParams
              ],

            ];

            foreach ($arrParams as &$category){
                foreach ($category['items'] as $key => &$item){
                    $item['id'] = $key;
                }
            }
        }

 $arrParams = json_encode($arrParams);
@endphp

    <params-categories params="{{$arrParams}}"></params-categories>


