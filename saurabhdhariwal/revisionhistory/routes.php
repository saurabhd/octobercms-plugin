<?php

Route::get('backend/revisions/{id}/{model}', "SaurabhDhariwal\Revisionhistory\Controllers\RevisionHistory@revisionDetails")->name('revisions.history');

?>