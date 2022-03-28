<?php

namespace Hengui\SecureShell;

class SSH
{
    /**
     * Instância da conexão
     * @var resource
     */
    private $connection;

    /**
     * Inicia a conexão SSH
     * @param $host string
     * @param $port int > 0 && < 65536
     * @return boolean
     */
    public function connect($host, $port)
    {
        $this->connection = ssh2_connect($host, $port);

        return (bool)$this->connection;
    }

    /**
     * Autentica com usuário e senha
     * @param $user string
     * @param $password string
     * @return boolean
     */
    public function authPassword($user, $password)
    {
        return $this->connection ? ssh2_auth_password($this->connection, $user, $password) : false;
    }

    /**
     * Remove conexão atual
     * return boolean
     */
    public function disconnect()
    {
        if ($this->connection) ssh2_disconnect($this->connection);

        $this->connection = null;

        return true;
    }

    /**
     * Executa comandos no SSH
     * @param $command string
     * @param $stdErr string
     * @return string
     */
    public function exec($command, &$stdErr = null)
    {
        if(!$this->connection) return null;

        if (!$stream = ssh2_exec($this->connection, $command)){
            return null;
        }

        stream_set_blocking($stream, true);

        $stdIo = $this->getOutput($stream, SSH2_STREAM_STDIO);

        $stdErr = $this->getOutput($stream, SSH2_STREAM_STDERR);

        stream_set_blocking($stream, false);

        return $stdIo;
    }

    /**
     * Obtém a saída da stream
     * @param $stream resource
     * @param $id int
     */
    private function getOutput($stream, $id)
    {
        $streamOut = ssh2_fetch_stream($stream ,$id);

        return stream_get_contents($streamOut);
    }
}