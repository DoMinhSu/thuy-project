@servers(['web' => '-o PasswordAuthentication=no -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -p 2222 -i C:\Users\ACER-NTC\.ssh\insecure_id_rsa laradock@localhost'])

{{-- php vendor/bin/envoy run deploy --}}

@setup
    $enabled = $enabled ?? true;
    $string = "string";
@endsetup

@story('deploy')
    task1
@endstory

@task('task1')
    cd /var/www
    {{-- cp .env .env-abc --}}
    echo "hellossssssssss {{$string}}" >> .env-abc
    @if ($branch)
        echo "{{$branch}}" >> .env-abc
    @endif
@endtask