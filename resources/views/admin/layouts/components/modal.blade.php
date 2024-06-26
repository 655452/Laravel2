<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"> {{__('frontend.delete_confirm')}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p class="mt-1 text-dark">  {{__('frontend.are_you_sure')}} </p>
                <button type="button" class="btn btn-danger rounded-0 mt-2" data-dismiss="modal"> {{__('levels.cancel')}}</button>
                <button id="delete-link" class="btn btn-primary rounded-0 mt-2"> {{__('levels.delete')}}</button>
            </div>
        </div>
    </div>
</div>
