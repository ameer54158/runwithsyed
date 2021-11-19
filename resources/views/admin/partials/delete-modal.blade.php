<!--begin:: Delete Modal -->
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1800">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('general.delete')}} </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" id="deleteForm">
                @csrf @method('DELETE')
                <div class="modal-body">
                    <p class="text-danger">{{__('general.delete message')}} <span class="extra-message"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('general.close')}}</button>
                    <button type="submit" class="btn btn-danger">{{__('general.delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end:: Delete Modal -->