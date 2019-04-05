<div class="modal fade text-left" id="{{ $modalId }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
            </div>
            <div class="modal-body" style="font-size: 18px">
                {{ $body }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-{{ $category ?? 'default'}}">Confirm</button>
            </div>
        </div>
    </div>
</div>
