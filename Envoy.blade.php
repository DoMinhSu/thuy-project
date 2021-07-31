@servers(['localhost' => ['laradock@localhost -p 2222']])
{{-- @servers(['localhost' => ['-o PasswordAuthentication=no -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null -p 2222 -i laradock/workspace/insecure_id_rsa laradock@localhost']]) --}}
{{-- @servers(['localhost' => 'root@127.0.0.1 -p 2222']) --}}
{{-- COPY insecure_id_rsa /tmp/id_rsa cấp quyền cho rsa --}} 
@task('abc', ['on' => 'localhost'])
    {{-- cd /home --}}
    ls -la
@endtask