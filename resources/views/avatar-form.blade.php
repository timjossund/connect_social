<x-layout>

  <div class="container py-md-5 container--narrow">
    <h2>Upload New Avatar</h2>
    <a href="/profile/{{auth()->user()->username}}"><p><< cancel update</p></a>
    <form action="/manage-avatar" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <input name="avatar" id="avatar" class="form-control form-control-lg form-control-file" type="file" placeholder="" autocomplete="off" />
        @error('avatar')
        <p class="m-0 small alert alert-danger shadow-sm">{{$message}}</p>
        @enderror
      </div>

      <button class="btn btn-primary">Save New Avatar</button>
    </form>
  </div>


</x-layout>