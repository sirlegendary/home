@servers(['web' => '90.205.138.220'])

@task('foo', ['on' => 'web'])
ls -la
@endtask