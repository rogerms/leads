@extends('layouts.master')

@section('title', 'Update Reps Info')

@section('content')
<div class="container">
    @include('partials.feedback')
    <textarea>
      <p>
          <img title="TinyMCE Logo" src="//www.tinymce.com/images/glyph-tinymce@2x.png" alt="TinyMCE Logo" width="110" height="97" />
      </p>

      <h2>What's new in TinyMCE 4.3</h2>

      <p>
          In this example we highlight new features in the 4.3 release, including the image caption option, media embeds and code snippets.
      </p>

      <ol>
          <li>
              <strong>Image captions</strong>: Click the image above. Click the image options hamburger in the modal. Check the 'caption' box and then click OK. Voila, editable captions.
          </li>
          <li>
              <strong>Media embeds</strong>: Click anywhere in the editable area. Click the video button in the toolbar. Add a YouTube url to the "source" input (here's a Star Wars trailer https://www.youtube.com/watch?v=sGbxmsDFVnE ). Click OK. You can even click
              play in the embedded video and watch it in the editor.
          </li>
          <li>
              <strong>Code Sample Plugin</strong>: Click the code sample button in the toolbar. Copy/paste a valid code block into the dialog popup and select the relevant language from the drop down. Click OK.
          </li>
      </ol>
      <p>&nbsp;</p>
    </textarea>
</div>
@endsection
