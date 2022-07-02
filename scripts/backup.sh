DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
stamp=`date +%Y-%d-%m-%H-%M-%S`

cd $DIR/..
sudo tar -czf ~/backups/db-$stamp.tar.gz ./
sudo cp ~/backups/db-$stamp.tar.gz /media/josh/BD9A-891F/range-events-2021/

echo "Backed up to ~/backups/db-$stamp.tar.gz"
