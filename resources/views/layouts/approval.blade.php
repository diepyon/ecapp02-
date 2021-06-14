{{--承認フォーム--}}
@if(Auth::user()->role=='administrator' and $stock->status=='inspection'){{--管理者なら　かつ投稿が承認待ちならにしたい andがきいてない--}}




<!-- Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvalModalTitle">承認確認</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                承認しますか
            </div>
            <div class="modal-footer">
                <form id="" action="/stock/approval" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                    <button type="submit" class="btn btn-primary">承認する</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="" action="/stock/reject" method="post" enctype="multipart/form-data">
            @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">却下理由</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($reasons as $key => $reason)
                    <div class="form-check">
                            <input class="form-check-input" type="checkbox"  id="{{$key}}" name="reasons[]" value="{{$key}}">
                        <label class="form-check-label" for="{{$key}}">
                            {{$reason}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="modal-footer">

  
                    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                    <button type="submit" class="btn btn-primary">マジで却下</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>


                </div>
            </form>
        </div>
    </div>
</div>


<div class="card text-white bg-dark mb-3">
    <div class="card-header">管理者モード</div>
    <div class="card-body">
        <h5 class="card-title">承認可否を選択</h5>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#approvalModal">
            承認
        </button>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter">
            却下
        </button>

    </div>
</div>

@endif
