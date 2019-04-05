<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#applicationModal">
    <span class="fa fa-check"></span> Apply for this position
</button>

<!-- Modal -->
<div class="modal fade text-left" id="applicationModal" tabindex="-1" role="dialog"
     aria-labelledby="applicationModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/home/applications" method="post">
                @csrf

                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <input type="hidden" name="jobpost_id" value="{{ $jobpost->id }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="applicationModalLabel">{{ $jobpost->title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="message">Message (Optional)</label>
                        <textarea name="message" id="message" class="form-control" rows="10"
                                  placeholder="Sending a concise message (3-5 sentences) will greatly increase your application's success. This is your chance to describe why you might be a great fit with the company's culture, or add some more information about yourself and how you might perform with the given tasks for the job."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
